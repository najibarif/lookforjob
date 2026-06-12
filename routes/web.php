<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobFrontendController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\ResumeBuilderController;
use App\Http\Controllers\ApplicationTrackerController;
use App\Http\Controllers\InterviewPrepController;
use App\Http\Controllers\SalaryInsightsController;
use App\Services\LinkedInService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di bawah ini adalah semua route untuk aplikasi Job & CV Helper.
|
*/

// Halaman utama
Route::get('/', function () {
    $featuredJobs = \App\Models\JobListing::inRandomOrder()->limit(3)->get();
    return view('home', compact('featuredJobs'));
})->name('home');

// Language Switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Halaman Perusahaan
Route::get('/companies', function () {
    return view('companies');
})->name('companies');

// Halaman About
Route::get('/about', function () {
    return view('about');
})->name('about');

// Halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// (Optional) Halaman register jika ada
// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// Halaman daftar pekerjaan (frontend)
Route::get('/jobs', [JobFrontendController::class, 'index'])->name('jobs');

// Halaman CV builder dipindahkan ke dalam auth middleware

// Halaman Detail Lowongan
Route::get('/jobs/detail', function (Request $request) {
    return view('jobs.detail', [
        'url' => $request->query('url'),
        'title' => $request->query('title', 'Position Unavailable'),
        'company' => $request->query('company', 'Company Unavailable'),
        'location' => $request->query('location') ?: 'Remote / Unspecified',
    ]);
})->name('jobs.detail');

// ----------------- API ROUTES -------------------

// API: Cron endpoint untuk mengambil pekerjaan setiap hari
Route::get('/api/cron/fetch-jobs', function (Request $request, \App\Services\JobAggregatorService $jobAggregatorService) {
    // Keamanan: Cek CRON_SECRET dari Vercel
    $expectedSecret = env('CRON_SECRET');
    $authHeader = $request->header('Authorization');

    if ($expectedSecret && $authHeader !== "Bearer {$expectedSecret}") {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    try {
        $jobs = $jobAggregatorService->fetchAndStore('developer', '', true);
        return response()->json([
            'success' => true,
            'message' => 'Successfully fetched and stored ' . count($jobs) . ' job(s).'
        ]);
    } catch (\Exception $e) {
        Log::error('Error in cron job:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});


// API: Ambil pekerjaan dari LinkedIn
Route::get('/ajax/linkedin-jobs', function (Request $request, LinkedInService $linkedInService) {
    $request->validate([
        'keyword' => 'required|string',
        'location' => 'required|string',
    ]);

    try {
        $data = $linkedInService->getJobs($request->input('keyword'), $request->input('location'));

        $formattedJobs = collect($data['data']['jobs'] ?? [])->map(function ($job) {
            return [
                'title' => $job['title'] ?? 'N/A',
                'company' => $job['company'] ?? 'N/A',
                'location' => $job['location'] ?? 'N/A',
                'description' => $job['description'] ?? 'N/A',
                'url' => $job['url'] ?? 'N/A',
            ];
        });

        return response()->json($formattedJobs);
    } catch (\Exception $e) {
        Log::error('Error fetching LinkedIn jobs:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// API: Ambil pekerjaan dari API umum (dari database, otomatis memperbarui jika belum ada)
Route::get('/ajax/jobs', [JobController::class, 'getJobs'])->name('api.jobs');

// Rute yang membutuhkan login
Route::middleware(['auth'])->group(function () {
    // Halaman CV builder
    Route::get('/cv', function () {
        return view('cv');
    })->name('cv');

    // API: Generate CV dari input user
    Route::post('/ajax/generate-cv', [CVController::class, 'create']);

    // Proses melamar pekerjaan
    Route::post('/jobs/apply', [JobFrontendController::class, 'apply'])->name('jobs.apply');

    // Halaman dasbor pelacakan lamaran
    Route::get('/my-applications', [JobFrontendController::class, 'myApplications'])->name('applications.index');

    // Halaman dan toggle simpan lowongan
    Route::get('/saved-jobs', [\App\Http\Controllers\SavedJobController::class, 'index'])->name('saved-jobs.index');
    Route::post('/saved-jobs/toggle', [\App\Http\Controllers\SavedJobController::class, 'toggle'])->name('saved-jobs.toggle');

    // Career Tools - Resume Builder
    Route::get('/career-tools/resume-builder', [ResumeBuilderController::class, 'index'])->name('career-tools.resume-builder');
    Route::post('/ajax/generate-resume', [ResumeBuilderController::class, 'generate']);

    // Career Tools - Application Tracker
    Route::get('/career-tools/application-tracker', [ApplicationTrackerController::class, 'index'])->name('career-tools.application-tracker');
    Route::post('/ajax/applications/{applicationId}/status', [ApplicationTrackerController::class, 'updateStatus']);

    // Career Tools - Interview Prep
    Route::get('/interview-prep', [InterviewPrepController::class, 'index'])->name('career-tools.interview-prep');
    Route::post('/ajax/interview-questions', [InterviewPrepController::class, 'generateQuestions']);
    Route::post('/ajax/interview/chat', [InterviewPrepController::class, 'processVoice']);
    Route::post('/ajax/interview/transcribe', [InterviewPrepController::class, 'transcribe']);

    // Career Tools - Salary Insights
    Route::get('/salary-insights', [SalaryInsightsController::class, 'index'])->name('career-tools.salary-insights');
    Route::post('/ajax/salary-data', [SalaryInsightsController::class, 'getSalaryData']);
});