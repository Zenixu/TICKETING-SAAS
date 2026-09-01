<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

// Route::middleware('auth:sanctum')->group(function () {
//     // User Authentication & Profile (Sanctum Token Based)
//     Route::get('user', [UserController::class, 'show']);
//     Route::put('user', [UserController::class, 'update']); // For Google OAuth token updates
//     Route::post('logout', [UserController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    // Event Management
    Route::apiResource('events', EventController::class)->parameters([
        'event' => 'event.uuid',
    ]);

    // Event Payments & Licensing
    Route::post('events/{event}/license/payment', [EventPaymentController::class, 'store']); // Create payment session for event license
    Route::get('events/{event}/payment-status', [EventPaymentController::class, 'show']); // Check payment status

    // Attendee Management (via QR Code scanning)
    Route::post('attendees/scan', [AttendeeController::class, 'scan']); // For QR Code scanning & check-in
    Route::get('events/{event}/attendees', [AttendeeController::class, 'index']); // List attendees for an event

    // Feedback & Post-Event Resources
    Route::post('attendees/{attendee}/feedback', [FeedbackController::class, 'store']); // Submit feedback
    Route::get('attendees/{attendee}/certificate', [FeedbackController::class, 'showCertificate']); // Download e-certificate
    Route::get('attendees/{attendee}/materials', [FeedbackController::class, 'showMaterials']); // Access event materials
});

// Public Routes (Authentication not required)
// Route::post('register', [UserController::class, 'register']); // Registration with email & password
// Route::post('login', [UserController::class, 'login']); // Login and receive Sanctum token
// Route::post('social-login/{driver}', [UserController::class, 'socialiteRedirect']); // Google OAuth redirect
// Route::get('social-callback/{driver}', [UserController::class, 'socialiteCallback']); // Google OAuth callback and token generation

// Web Routes for E-Ticket Generation & Display
// Route::get('events/{event}/ticket/{attendee}', [WebTicketController::class, 'show']); // HTML/QR page for participants
// Route::get('events/{event}/attendee/checkin', [WebTicketController::class, 'checkInPage']); // HTML page for check-in
