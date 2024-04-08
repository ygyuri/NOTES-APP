<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Use controllers with full namespaces
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\NoteController; // Assuming NoteController is also in API subdirectory

// Routes for user registration and authentication
Route::post('/register', [UserController::class, 'register']); // Register a new user
Route::post('/login', [UserController::class, 'login']); // Login existing user

// Get the authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Secure CRUD routes for managing notes with Sanctum authentication middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/createNotes', [NoteController::class, 'store']); // Create a new note
    Route::get('/notes', [NoteController::class, 'index']); // Get all notes
    Route::get('/notes/{id}', [NoteController::class, 'show']); // Get a single note by ID
    Route::post('/notes/{id}', [NoteController::class, 'update']); // Update a note by ID
    Route::post('/notes/{id}/delete', [NoteController::class, 'destroy']); // Delete a note by ID
});