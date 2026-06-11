<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobFrontendController;
use App\Http\Controllers\CVController;
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
    return view('home');
})->name('home');

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
        'title' => $request->query('title', 'Senior Frontend Developer'),
        'company' => $request->query('company', 'Tech Innovators Inc.'),
        'location' => $request->query('location', 'Jakarta Selatan'),
    ]);
})->name('jobs.detail');

// ----------------- API ROUTES -------------------



// API: Ambil pekerjaan dari LinkedIn
Route::get('/api/linkedin-jobs', function (Request $request, LinkedInService $linkedInService) {
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
Route::get('/api/jobs', [JobController::class, 'getJobs'])->name('api.jobs');

// Rute yang membutuhkan login
Route::middleware(['auth'])->group(function () {
    // Halaman CV builder
    Route::get('/cv', function () {
        return view('cv');
    })->name('cv');

    // API: Generate CV dari input user
    Route::post('/api/generate-cv', [CVController::class, 'create']);

    // Proses melamar pekerjaan
    Route::post('/jobs/apply', [JobFrontendController::class, 'apply'])->name('jobs.apply');

    // Halaman dasbor pelacakan lamaran
    Route::get('/my-applications', [JobFrontendController::class, 'myApplications'])->name('applications.index');

    // Halaman dan toggle simpan lowongan
    Route::get('/saved-jobs', [\App\Http\Controllers\SavedJobController::class, 'index'])->name('saved-jobs.index');
    Route::post('/saved-jobs/toggle', [\App\Http\Controllers\SavedJobController::class, 'toggle'])->name('saved-jobs.toggle');
});