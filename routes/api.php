<?php

use Illuminate\Support\Facades\Route;

// Public project endpoints
Route::get('projects', [App\Http\Controllers\Api\ProjectController::class, 'index']);
Route::get('projects/{slug}', [App\Http\Controllers\Api\ProjectController::class, 'show']);

// Public skill endpoints
Route::get('skills', [App\Http\Controllers\Api\SkillController::class, 'index']);
Route::get('skills/all', [App\Http\Controllers\Api\SkillController::class, 'all']);

// Public experience endpoints
Route::get('experience', [App\Http\Controllers\Api\ExperienceController::class, 'index']);
Route::get('experience/jobs', [App\Http\Controllers\Api\ExperienceController::class, 'jobs']);
Route::get('experience/education', [App\Http\Controllers\Api\ExperienceController::class, 'education']);

// Public testimonials
Route::get('testimonials', [App\Http\Controllers\Api\TestimonialController::class, 'index']);

// Contact form
Route::post('contact', [App\Http\Controllers\Api\ContactController::class, 'store']);

// Social links
Route::get('social-links', [App\Http\Controllers\Api\SocialLinkController::class, 'index']);

// Admin project endpoints (require authentication)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('projects', [App\Http\Controllers\Api\Admin\ProjectController::class, 'index']);
    Route::post('projects', [App\Http\Controllers\Api\Admin\ProjectController::class, 'store']);
    Route::get('projects/{id}', [App\Http\Controllers\Api\Admin\ProjectController::class, 'show']);
    Route::post('projects/{id}', [App\Http\Controllers\Api\Admin\ProjectController::class, 'update']);
    Route::delete('projects/{id}', [App\Http\Controllers\Api\Admin\ProjectController::class, 'destroy']);
    
    // Admin skills
    Route::get('skills', [App\Http\Controllers\Api\Admin\SkillController::class, 'index']);
    Route::post('skills', [App\Http\Controllers\Api\Admin\SkillController::class, 'store']);
    Route::get('skills/{id}', [App\Http\Controllers\Api\Admin\SkillController::class, 'show']);
    Route::post('skills/{id}', [App\Http\Controllers\Api\Admin\SkillController::class, 'update']);
    Route::delete('skills/{id}', [App\Http\Controllers\Api\Admin\SkillController::class, 'destroy']);

    // Admin experiences
    Route::get('experience', [App\Http\Controllers\Api\Admin\ExperienceController::class, 'index']);
    Route::post('experience', [App\Http\Controllers\Api\Admin\ExperienceController::class, 'store']);
    Route::get('experience/{id}', [App\Http\Controllers\Api\Admin\ExperienceController::class, 'show']);
    Route::post('experience/{id}', [App\Http\Controllers\Api\Admin\ExperienceController::class, 'update']);
    Route::delete('experience/{id}', [App\Http\Controllers\Api\Admin\ExperienceController::class, 'destroy']);

    // Admin testimonials
    Route::get('testimonials', [App\Http\Controllers\Api\Admin\TestimonialController::class, 'index']);
    Route::post('testimonials', [App\Http\Controllers\Api\Admin\TestimonialController::class, 'store']);
    Route::get('testimonials/{id}', [App\Http\Controllers\Api\Admin\TestimonialController::class, 'show']);
    Route::post('testimonials/{id}', [App\Http\Controllers\Api\Admin\TestimonialController::class, 'update']);
    Route::delete('testimonials/{id}', [App\Http\Controllers\Api\Admin\TestimonialController::class, 'destroy']);

    // Admin social links
    Route::get('social-links', [App\Http\Controllers\Api\Admin\SocialLinkController::class, 'index']);
    Route::post('social-links', [App\Http\Controllers\Api\Admin\SocialLinkController::class, 'store']);
    Route::get('social-links/{id}', [App\Http\Controllers\Api\Admin\SocialLinkController::class, 'show']);
    Route::post('social-links/{id}', [App\Http\Controllers\Api\Admin\SocialLinkController::class, 'update']);
    Route::delete('social-links/{id}', [App\Http\Controllers\Api\Admin\SocialLinkController::class, 'destroy']);

    // Admin tags
    Route::get('tags', [App\Http\Controllers\Api\Admin\TagController::class, 'index']);
    Route::post('tags', [App\Http\Controllers\Api\Admin\TagController::class, 'store']);
    Route::get('tags/{id}', [App\Http\Controllers\Api\Admin\TagController::class, 'show']);
    Route::post('tags/{id}', [App\Http\Controllers\Api\Admin\TagController::class, 'update']);
    Route::delete('tags/{id}', [App\Http\Controllers\Api\Admin\TagController::class, 'destroy']);

    // Admin messages
    Route::get('messages', [App\Http\Controllers\Api\Admin\MessageController::class, 'index']);
    Route::get('messages/{id}', [App\Http\Controllers\Api\Admin\MessageController::class, 'show']);
    Route::delete('messages/{id}', [App\Http\Controllers\Api\Admin\MessageController::class, 'destroy']);
});
