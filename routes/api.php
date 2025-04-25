<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//client routes
use App\Http\Controllers\ClientController;

Route::post('/clients', [ClientController::class, 'store']);         // Register client
Route::get('/clients/search', [ClientController::class, 'search']);  // Search clients
Route::get('/clients/{id}', [ClientController::class, 'show']);      // View profile
Route::put('/clients/{id}', [ClientController::class, 'update']);    // Update client information
Route::delete('/clients/{id}', [ClientController::class, 'destroy']); // Delete a client
Route::get('/clients', [ClientController::class, 'index']);          // Paginate client list
Route::get('/clients/filter', [ClientController::class, 'filter']);  // Filter clients by criteria
Route::post('/clients/{clientId}/assign-user', [ClientController::class, 'assignUser']); // Assign a user to a client
Route::post('/clients/{clientId}/unassign-user', [ClientController::class, 'unassignUser']); // Unassign a user from a client


//program routes
use App\Http\Controllers\ProgramController;

Route::post('/programs', [ProgramController::class, 'store']);       // Create a program
Route::get('/programs', [ProgramController::class, 'index']);        // List all programs
Route::put('/programs/{id}', [ProgramController::class, 'update']);  // Update a program
Route::patch('/programs/{id}/suspend', [ProgramController::class, 'suspend']); // Suspend a program


//enrollment routes
use App\Http\Controllers\EnrollmentController;

Route::post('/enrollments', [EnrollmentController::class, 'enroll']);          // Enroll a client into programs
Route::delete('/enrollments', [EnrollmentController::class, 'unenroll']);      // Unenroll a client from programs


//appointment routes
use App\Http\Controllers\AppointmentController;

Route::post('/appointments', [AppointmentController::class, 'store']);         // Schedule an appointment
Route::get('/appointments', [AppointmentController::class, 'index']);          // View all appointments
Route::get('/appointments/{id}', [AppointmentController::class, 'show']);      // View a specific appointment
Route::put('/appointments/{id}', [AppointmentController::class, 'update']);    // Update an appointment
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']); // Cancel an appointment


//notification routes
use App\Http\Controllers\NotificationController;

Route::post('/notifications', [NotificationController::class, 'store']);         // Create and send a notification
Route::get('/notifications', [NotificationController::class, 'index']);          // Retrieve notifications for a client or user
Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']); // Mark a notification as read
