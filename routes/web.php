<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Redirect the root URL straight to your main task dashboard index
Route::get('/', [TaskController::class, 'index'])->name('home');

// Standard resource routes for tasks (handles index, store, update, destroy, etc.)
Route::resource('tasks', TaskController::class);

// Dedicated route for the quick Pending/Completed status toggle button
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');