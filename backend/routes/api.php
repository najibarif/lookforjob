<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CVController;
use App\Http\Controllers\API\PendidikanController;
use App\Http\Controllers\API\PengalamanController;
use App\Http\Controllers\API\SkillController;
use App\Http\Controllers\API\ScrapedJobController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // CV routes
    Route::prefix('cv')->group(function () {
        Route::get('/', [CVController::class, 'show']);
        Route::post('/', [CVController::class, 'store']);
        Route::post('/generate', [CVController::class, 'generateWithAI']);
        Route::get('/export', [CVController::class, 'exportPDF']);
        Route::get('/preview', [CVController::class, 'previewPDF']);
        Route::post('/match-jobs', [CVController::class, 'matchJobs']);
        Route::post('/analyze-upload', [CVController::class, 'analyzeUploadedCV']);
        Route::post('/ai-chat', [CVController::class, 'chatWithAIAboutCV']);
    });

    // Experience routes
    Route::apiResource('pengalaman', PengalamanController::class);

    // Education routes
    Route::apiResource('pendidikan', PendidikanController::class);

    // Skills routes
    Route::apiResource('skills', SkillController::class);

    // Routes for pencari kerja
    Route::middleware(['role:pencari kerja'])->group(function () {
        // Add specific routes for job seekers here
    });

    // Routes for recruiter
    Route::middleware(['role:recruiter'])->group(function () {
        // Add specific routes for recruiters here
    });

    // Routes for admin
    Route::middleware(['role:admin'])->group(function () {
        // Add specific routes for admins here
    });
});

// Public API untuk hasil scraping jobs
Route::get('/jobs', [ScrapedJobController::class, 'index']);
Route::get('/jobs/{id}', [ScrapedJobController::class, 'show']);

Route::get('/scraped-jobs', [ScrapedJobController::class, 'index']);
Route::get('/scraped-jobs/{id}', [ScrapedJobController::class, 'show']);