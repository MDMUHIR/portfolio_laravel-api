<?php

use Illuminate\Support\Facades\Route;

// Public project endpoints
Route::get('projects', [App\Http\Controllers\Api\ProjectController::class, 'index']);
Route::get('projects/{slug}', [App\Http\Controllers\Api\ProjectController::class, 'show']);

// Admin project endpoints (require authentication)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('projects', [App\Http\Controllers\Api\Admin\ProjectController::class, 'index']);
    Route::post('projects', [App\Http\Controllers\Api\Admin\ProjectController::class, 'store']);
    Route::get('projects/{id}', [App\Http\Controllers\Api\Admin\ProjectController::class, 'show']);
    Route::post('projects/{id}', [App\Http\Controllers\Api\Admin\ProjectController::class, 'update']);
    Route::delete('projects/{id}', [App\Http\Controllers\Api\Admin\ProjectController::class, 'destroy']);
});
