<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ChatController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\EnsureRole;
use App\Models\User;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-based routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Admin Routes
    Route::middleware('role:'.User::ROLE_ADMIN)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/service-requests', [AdminController::class, 'serviceRequests'])->name('service_requests');
        Route::post('/service-requests/{request}/assign', [AdminController::class, 'assignStaff'])->name('service_requests.assign');

        // Admin Customers
        Route::resource('customers', \App\Http\Controllers\AdminCustomerController::class)->only(['index', 'show', 'edit', 'update']);
        Route::post('/customers/{customer}/upload-document', [\App\Http\Controllers\AdminCustomerController::class, 'uploadDocument'])->name('customers.upload_document');

        // Admin Staff
        Route::resource('staff', \App\Http\Controllers\AdminStaffController::class)->except(['destroy']);

        // Admin Affiliates
        Route::resource('affiliates', \App\Http\Controllers\AdminAffiliateController::class)->except(['destroy']);
        Route::post('/affiliates/{affiliate}/verify', [\App\Http\Controllers\AdminAffiliateController::class, 'verify'])->name('affiliates.verify');
    });

    // Staff Routes
    Route::middleware('role:'.User::ROLE_STAFF)->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
        Route::get('/requests', [StaffController::class, 'assignedRequests'])->name('requests');
        Route::get('/requests/{request}', [StaffController::class, 'showRequest'])->name('requests.show');
        Route::post('/requests/{request}/status', [StaffController::class, 'updateStatus'])->name('requests.status');
        Route::post('/requests/{request}/toggle-chat', [StaffController::class, 'toggleChat'])->name('requests.toggle_chat');
    });

    // Customer Routes
    Route::middleware('role:'.User::ROLE_CUSTOMER)->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/requests', [CustomerController::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [CustomerController::class, 'create'])->name('requests.create');
        Route::post('/requests', [CustomerController::class, 'store'])->name('requests.store');
        Route::get('/requests/{request}', [CustomerController::class, 'show'])->name('requests.show');
    });

    // Affiliate Routes
    Route::middleware('role:'.User::ROLE_AFFILIATE)->prefix('affiliate')->name('affiliate.')->group(function () {
        Route::get('/dashboard', [AffiliateController::class, 'dashboard'])->name('dashboard');
    });

    // Chat Routes (Shared but protected by service logic)
    Route::post('/chat/{request}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{request}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
});

require __DIR__.'/auth.php';
