<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\JobScraper;

class JobFrontendController extends Controller
{
    public function index(Request $request, JobScraper $scraper)
    {
        $keyword = (string) $request->input('keyword');
        $location = (string) $request->input('location');
        $refresh = $request->boolean('refresh', false);
        $page = (int) $request->input('page', 1);
        $perPage = 20;

        try {
            $allJobs = collect($scraper->scrapeIndeed($keyword, $location, $refresh));
            $lastRefreshedAt = $allJobs->max('updated_at') ?: now()->toDateTimeString();

            $jobs = new LengthAwarePaginator(
                $allJobs->forPage($page, $perPage)->values(),
                $allJobs->count(),
                $perPage,
                $page,
                [
                    'path' => url('/jobs'),
                    'query' => $request->except('page'),
                ]
            );

            if ($request->boolean('ajax')) {
                $nextUrl = $jobs->hasMorePages() ? $jobs->nextPageUrl() : null;
                return response()->json([
                    'html' => view('jobs.partials.job-cards', ['jobs' => $jobs, 'offset' => $jobs->firstItem() - 1])->render(),
                    'next_url' => $nextUrl,
                    'current_page' => $jobs->currentPage(),
                    'last_page' => $jobs->lastPage(),
                ]);
            }

            return view('jobs.index', compact('jobs', 'keyword', 'location', 'lastRefreshedAt'));
        } catch (\Exception $e) {
            return view('jobs.index', [
                'jobs' => collect(),
                'error' => $e->getMessage(),
                'keyword' => $keyword,
                'location' => $location,
                'lastRefreshedAt' => now()->toDateTimeString(),
            ]);
        }
    }

    public function apply(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
            'job_title' => 'required',
            'company_name' => 'required',
            'job_url' => 'required',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        if (empty($user->cv_html)) {
            return back()->with('error', 'Anda belum membuat CV. Silakan buat CV terlebih dahulu di menu Buat CV.');
        }

        // Cek apakah sudah pernah melamar
        $existing = \App\Models\JobApplication::where('user_id', $user->id)
            ->where('job_id', $request->input('job_id'))
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melamar pekerjaan ini sebelumnya.');
        }

        \App\Models\JobApplication::create([
            'user_id' => $user->id,
            'job_id' => $request->input('job_id'),
            'job_title' => $request->input('job_title'),
            'company_name' => $request->input('company_name'),
            'job_url' => $request->input('job_url'),
            'cv_snapshot' => $user->cv_html,
            'status' => 'Terkirim',
        ]);

        return back()->with('success', 'Berhasil melamar pekerjaan! Resume Anda telah dikirimkan secara internal.');
    }

    public function myApplications()
    {
        $applications = \App\Models\JobApplication::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }
}
