# Software Architecture Overview

## 1. System Overview
**Sarthi** is an enterprise-grade service management platform designed for multi-role operations involving Customers, Staff, Admins, and Affiliates. It follows a **Domain-Driven Design (DDD)** approach within a monolithic Laravel architecture, utilizing **Inertia.js** for a modern Single Page Application (SPA) feel without the complexity of a separate API.

### High-Level Components
*   **Frontend**: React 18 + Tailwind CSS (served via Inertia.js).
*   **Backend**: Laravel 12 (PHP 8.2+).
*   **Database**: SQLite (Dev) / MySQL (Production).
*   **Real-Time Layer**: Laravel Reverb (WebSockets) + Laravel Echo.

---

## 2. Core Architecture Patterns

### Domain-Driven Services
The application logic is strictly separated from Controllers. Controllers are "thin" and delegate logic to **Domain Services** located in `app/Domain/Services`.

*   **Controllers**: Handle HTTP requests, validate input, call Services, and return Inertia responses.
*   **Services**: Encapsulate business logic (e.g., state transitions, assignments, complex validation).
*   **Models**: Eloquent models representing the database schema with strict foreign keys.

### Request Flow
1.  **User Action**: A user interacts with the React frontend (e.g., submits a form).
2.  **Inertia Request**: Inertia sends an XHR request to a Laravel route.
3.  **Middleware**: `EnsureRole` middleware validates if the user has the required role (Admin, Staff, Customer, etc.).
4.  **Controller**: The controller receives the request.
5.  **Service Layer**: The controller calls a specific method in a Domain Service (e.g., `ServiceRequestService::createRequest`).
6.  **Database**: The Service interacts with Eloquent Models to persist data within a transaction.
7.  **Response**: The Service returns the result object. The Controller returns an `Inertia::render` response or a redirect.
8.  **Frontend Update**: Inertia updates the page content dynamically without a full reload.

---

## 3. Key Workflows

### A. Service Request Lifecycle
This is the core operational flow of the system.

1.  **Creation**: A **Customer** selects a service and submits a request via `CustomerController`.
    *   *Service*: `ServiceRequestService` validates eligibility and creates a `ServiceRequest` record with status `pending`.
2.  **Assignment**: An **Admin** views pending requests on the Dashboard.
    *   *Action*: Admin selects a Staff member.
    *   *Service*: `AssignmentService` updates `assigned_to` and changes status to `assigned`.
3.  **Processing**: The **Staff** member sees the request in their "My Requests" list.
    *   *Action*: Staff reviews docs, updates status to `in_progress`, or requests info.
    *   *Service*: `ServiceRequestService` enforces valid status transitions (e.g., cannot go from `pending` directly to `completed`).
4.  **Communication**: Chat is enabled by Staff. Messages are exchanged via `RequestChatService`.
5.  **Completion**: Staff marks the request as `completed`. Invoice generation (optional) is handled by `InvoiceService`.

### B. Role-Based Access Control (RBAC)
Security is enforced at multiple layers:
*   **Routes**: Protected by `role:admin`, `role:staff`, etc., middleware alias for `EnsureRole`.
*   **Services**: Methods explicitly check `if (!$user->isAdmin())` before performing sensitive actions.
*   **Frontend**: UI elements (buttons, links) are conditionally rendered based on `auth.user.role`.

### C. Real-Time Chat
1.  **Sending**: User sends a message via `ChatController`.
2.  **Broadcasting**: `RequestChatService` saves the message and dispatches a `RequestMessageCreated` event.
3.  **Transport**: Laravel Reverb broadcasts the event over a private/presence channel `presence-request.{id}`.
4.  **Receiving**: Laravel Echo (Frontend) listens for the event and appends the new message to the chat list instantly.

---

## 4. Directory Structure Highlights

*   `app/Domain/Services/`: Contains all business logic (`ServiceRequestService`, `AssignmentService`, etc.).
*   `app/Http/Controllers/`: Role-specific controllers (`AdminController`, `StaffController`, etc.).
*   `app/Models/`: Strict Eloquent models (`CustomerProfile`, `ServiceRequest`, etc.).
*   `resources/js/Pages/`: Inertia pages organized by Role (`Admin/`, `Staff/`, `Customer/`).
*   `resources/js/Layouts/`: Specific layouts for each role to provide distinct navigation.

## 5. Database Schema Overview
*   **Users**: Central identity table with `role` column.
*   **Profiles**: `cab_custmr_prfl`, `cab_staff_prfl`, `cab_aff` (linked 1:1 to Users).
*   **Service Domain**: `services`, `service_requests` (central transaction table), `request_messages`.
*   **Financials**: `cab_invc` (Invoices), `cab_pymt` (Payments).

This architecture ensures scalability, maintainability, and strict adherence to business rules, separating "how data is presented" (Controllers/Frontend) from "how business works" (Services).
