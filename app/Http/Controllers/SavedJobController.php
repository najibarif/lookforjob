<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedJob;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function index()
    {
        $savedJobs = SavedJob::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('saved-jobs.index', compact('savedJobs'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
            'title' => 'required',
            'company' => 'required',
            'location' => 'nullable',
            'url' => 'nullable',
        ]);

        $userId = Auth::id();
        $jobId = $request->input('job_id');

        $existing = SavedJob::where('user_id', $userId)->where('job_id', $jobId)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('status', 'Lowongan dihapus dari daftar tersimpan.');
        } else {
            SavedJob::create([
                'user_id' => $userId,
                'job_id' => $jobId,
                'title' => $request->input('title'),
                'company' => $request->input('company'),
                'location' => $request->input('location'),
                'url' => $request->input('url'),
            ]);
            return back()->with('status', 'Lowongan berhasil disimpan.');
        }
    }
}
