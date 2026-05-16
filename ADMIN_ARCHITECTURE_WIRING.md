# Admin Panel Architecture & Wiring Documentation

This document explains the architectural wiring and request lifecycle for the newly implemented Admin Panel CRUD features: **Customers**, **Staff**, and **Affiliates**. The implementation strictly follows the application's Domain-Driven Design (DDD) principles.

---

## 1. Routing Layer (`routes/web.php`)
The entry points for the Admin panel are protected by the `auth`, `verified`, and `role:admin` middlewares.

```php
Route::middleware(['auth', 'verified', 'role:'.User::ROLE_ADMIN])->prefix('admin')->name('admin.')->group(function () {
    // Customers
    Route::resource('customers', AdminCustomerController::class)->only(['index', 'show', 'edit', 'update']);
    Route::post('/customers/{customer}/upload-document', [AdminCustomerController::class, 'uploadDocument'])->name('customers.upload_document');

    // Staff
    Route::resource('staff', AdminStaffController::class)->except(['destroy']);

    // Affiliates
    Route::resource('affiliates', AdminAffiliateController::class)->except(['destroy']);
    Route::post('/affiliates/{affiliate}/verify', [AdminAffiliateController::class, 'verify'])->name('affiliates.verify');
});
```
* **Why:** This ensures that only users with the `User::ROLE_ADMIN` can access these routes. Resource controllers are used for standard CRUD operations, while specific actions (like uploading documents or verifying affiliates) use dedicated explicit routes.

---

## 2. Controller Layer (`app/Http/Controllers/`)
The controllers are kept "thin." They are responsible for:
1.  **Validating Input:** Using `$request->validate(...)` to ensure data integrity before it reaches the domain layer.
2.  **Delegating Business Logic:** Calling the injected Domain Service.
3.  **Returning Responses:** Rendering an Inertia component or redirecting back with success/error messages.

### Example: `AdminAffiliateController`
```php
class AdminAffiliateController extends Controller
{
    protected $adminAffiliateService;

    // 1. Dependency Injection of the Domain Service
    public function __construct(AdminAffiliateService $adminAffiliateService) {
        $this->adminAffiliateService = $adminAffiliateService;
    }

    public function store(Request $request) {
        // 2. Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // ...
        ]);

        try {
            // 3. Delegation
            $this->adminAffiliateService->createAffiliate($validated);
            // 4. Response
            return redirect()->route('admin.affiliates.index')->with('success', 'Affiliate created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
```

---

## 3. Domain Service Layer (`app/Domain/Services/`)
This is where the core business logic resides. Services handle multi-table interactions, hash passwords, and manage file storage.

### Transactions
All service methods that modify data use `DB::transaction()`. If any operation fails (e.g., creating the User succeeds but creating the Profile fails), the entire transaction rolls back, preventing orphaned records.

### Example: `AdminAffiliateService`
```php
class AdminAffiliateService
{
    public function createAffiliate(array $data): Affiliate
    {
        return DB::transaction(function () use ($data) {
            // Step 1: Create the User account
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']), // Secure hashing
                'role' => User::ROLE_AFFILIATE,
                'stau' => 1,
            ]);

            // Step 2: Create the linked Affiliate Profile
            return Affiliate::create([
                'user_id' => $user->id, // Foreign Key link
                'fa_nm' => $data['fa_nm'],
                // ...
            ]);
        });
    }
}
```

---

## 4. Frontend Layer (React + Inertia.js)
The frontend relies on `Inertia.js` to bridge Laravel routing with React components, providing an SPA experience.

*   **Location:** `resources/js/Pages/Admin/{ResourceName}/`
*   **Forms:** Managed using Inertia's `useForm` hook.

### Key Interaction: Affiliate Verification Toggle
A notable architectural choice is how boolean toggles are handled without relying on two-way data binding that might lag behind server state.

In `resources/js/Pages/Admin/Affiliates/Show.jsx`:
```javascript
import { useForm } from '@inertiajs/react';

export default function Show({ affiliate }) {
    const { transform, post: postForm, processing: formProcessing } = useForm({
        is_vf: false, // Default initial state
    });

    const toggleVerification = () => {
        // Calculate the next state based on the actual prop from the server
        const nextStatus = affiliate.user?.is_vf ? false : true;

        // Use transform to inject the calculated state into the payload right before posting
        transform((data) => ({
            ...data,
            is_vf: nextStatus,
        }));

        // Dispatch the POST request
        postForm(route('admin.affiliates.verify', affiliate.cab_aff_uin));
    };

    return (
        <PrimaryButton onClick={toggleVerification} disabled={formProcessing}>
            {affiliate.user?.is_vf ? 'Revoke Verification' : 'Verify Affiliate'}
        </PrimaryButton>
    );
}
```
* **Why `transform`:** Because Inertia's `post()` method uses the *current* state of the form. `setData()` is asynchronous in React. Using `transform` guarantees the exact, intended payload is sent to the server.

---

## 5. Summary of Data Flow
1. **User Action:** Admin clicks "Save" on the *Create Staff* React page.
2. **Inertia XHR:** `useForm().post(route('admin.staff.store'))` sends a JSON payload to the server.
3. **Routing:** `web.php` routes the request to `AdminStaffController@store`.
4. **Controller:** Validates the payload. If invalid, Inertia catches the 422 error and displays it on the form.
5. **Service:** If valid, `AdminStaffService@createStaff` opens a DB transaction, hashes the password, creates the `User`, creates the `StaffProfile`, and commits the transaction.
6. **Response:** Controller returns a `redirect()->route('admin.staff.index')`.
7. **Inertia Update:** Inertia intercepts the redirect and dynamically swaps out the React page content to show the `Index` view without a full page reload.
