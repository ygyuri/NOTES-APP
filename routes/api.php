<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

// Routes for user registration and authentication
Route::post('/register', [UserController::class, 'register']); // Register a new user
Route::post('/login', [UserController::class, 'login']); // Login existing user

// Get the authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Secure CRUD routes for managing notes with Sanctum authentication middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/notes', [NoteController::class, 'store']); // Create a new note
    Route::get('/notes', [NoteController::class, 'index']); // Get all notes
    Route::get('/notes/{note}', [NoteController::class, 'show']); // Get a single note by ID
    Route::put('/notes/{note}', [NoteController::class, 'update']); // Update a note by ID
    Route::delete('/notes/{note}', [NoteController::class, 'destroy']); // Delete a note by ID
});