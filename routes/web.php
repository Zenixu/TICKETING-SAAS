<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizerRequestController;
use App\Http\Controllers\EventCatalogController;
use App\Http\Controllers\SocialiteController;

// 1. PUBLIC ROUTES (Landing & Katalog Event untuk User Biasa)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalog', [EventCatalogController::class, 'index'])->name('events.catalog');
Route::get('/catalog/{event}', [EventCatalogController::class, 'show'])->name('events.public-show');

// 2. GUEST ROUTES (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    // Google OAuth (Socialite) Routes
    Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// 3. AUTHENTICATED ROUTES
Route::middleware('auth')->group(function () {
    // Mendukung POST dan GET untuk route logout agar aman jika diakses via URL biasa
    Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])->name('logout');

    // User Biasa mengajukan diri menjadi Organizer Event
    Route::post('request-organizer', [OrganizerRequestController::class, 'request'])->name('request-organizer');

    // ROUTE ORGANIZER & ADMIN (Pembuat Event & Tiket)
    Route::middleware('role:organizer,admin')->group(function () {
        Route::get('dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });

    // ROUTE KHUSUS ADMIN CONSOLE (Hanya Admin yang bisa akses)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('organizers/{user}/approve', [AdminController::class, 'approveOrganizer'])->name('organizers.approve');
        Route::post('organizers/{user}/reject', [AdminController::class, 'rejectOrganizer'])->name('organizers.reject');
        Route::post('users/{user}/role', [AdminController::class, 'updateRole'])->name('users.update-role');
    });
});
