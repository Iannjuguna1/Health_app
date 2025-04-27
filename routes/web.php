<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProgramLogController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/clients', [ClientController::class, 'index']); // List clients
//Route::get('/programs', [ProgramController::class, 'index']); // List programs
Route::get('/api/programs', [ProgramController::class, 'index']); // JSON response

// Web route
Route::get('/programs', [ProgramController::class, 'indexView']); // Blade view



// Route to display the form
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');

// Route to handle form submission
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

//programs
Route::get('/programs/create', [ProgramController::class, 'create']); // Show form
Route::post('/programs', [ProgramController::class, 'store']); // Handle form submission

//enrolment
Route::get('/enrollments/create', [EnrollmentController::class, 'create']); // Show form
Route::post('/enrollments', [EnrollmentController::class, 'store']); // Handle form submission

Route::get('/clients/{id}', [ClientController::class, 'show']); // View a single client
