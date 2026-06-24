<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\PageController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobFrontendController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\InterviewPrepController;
use App\Http\Controllers\SalaryInsightsController;
use App\Services\Jobs\JobAggregator;
use App\Services\Jobs\Providers\LinkedInProvider;
use App\Services\Jobs\Data\JobData;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/companies', [PageController::class, 'companies'])->name('companies');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/jobs', [JobFrontendController::class, 'index'])->name('jobs');
Route::get('/jobs/detail', [JobFrontendController::class, 'detail'])->name('jobs.detail');

Route::get('/api/cron/fetch-jobs', function (Request $request, JobAggregator $aggregator) {
    $expectedSecret = config('app.cron_secret');
    $authHeader = $request->header('Authorization');

    if ($expectedSecret && $authHeader !== "Bearer {$expectedSecret}") {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    try {
        $jobs = $aggregator->fetchAndStore('developer', '', true);
        return response()->json([
            'success' => true,
            'message' => 'Successfully fetched and stored ' . count($jobs) . ' job(s).'
        ]);
    } catch (\Exception $e) {
        Log::error('Error in cron job:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/ajax/linkedin-jobs', function (Request $request, LinkedInProvider $linkedInProvider) {
    $request->validate([
        'keyword' => 'required|string',
        'location' => 'required|string',
    ]);

    try {
        $jobs = $linkedInProvider->fetchJobs($request->input('keyword'), $request->input('location'));

        $formattedJobs = collect($jobs)->map(fn (JobData $job) => [
            'title' => $job->title,
            'company' => $job->company,
            'location' => $job->locationText,
            'description' => $job->description,
            'url' => $job->url,
        ]);

        return response()->json($formattedJobs);
    } catch (\Exception $e) {
        Log::error('Error fetching LinkedIn jobs:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/ajax/jobs', [JobController::class, 'getJobs'])->name('api.jobs');

Route::middleware(['auth'])->group(function () {
    Route::get('/cv', function () {
        return view('cv');
    })->name('cv');

    Route::post('/ajax/generate-cv', [CVController::class, 'create']);

    Route::post('/jobs/apply', [JobFrontendController::class, 'apply'])->name('jobs.apply');

    Route::get('/my-applications', [JobFrontendController::class, 'myApplications'])->name('applications.index');

    Route::get('/saved-jobs', [\App\Http\Controllers\SavedJobController::class, 'index'])->name('saved-jobs.index');
    Route::post('/saved-jobs/toggle', [\App\Http\Controllers\SavedJobController::class, 'toggle'])->name('saved-jobs.toggle');

    Route::get('/interview-prep', [InterviewPrepController::class, 'index'])->name('career-tools.interview-prep');
    Route::post('/ajax/interview-questions', [InterviewPrepController::class, 'generateQuestions']);
    Route::post('/ajax/interview/chat', [InterviewPrepController::class, 'processVoice']);
    Route::post('/ajax/interview/transcribe', [InterviewPrepController::class, 'transcribe']);

    Route::get('/salary-insights', [SalaryInsightsController::class, 'index'])->name('career-tools.salary-insights');
    Route::post('/ajax/salary-data', [SalaryInsightsController::class, 'getSalaryData']);
});
