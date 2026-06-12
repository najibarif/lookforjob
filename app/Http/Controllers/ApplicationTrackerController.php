<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;

class ApplicationTrackerController extends Controller
{
    /**
     * Display the application tracker dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $applications = JobApplication::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $applications->count(),
            'applied' => $applications->where('status', 'applied')->count(),
            'shortlisted' => $applications->where('status', 'shortlisted')->count(),
            'interviewed' => $applications->where('status', 'interviewed')->count(),
            'offered' => $applications->where('status', 'offered')->count(),
            'rejected' => $applications->where('status', 'rejected')->count(),
        ];

        return view('career-tools.application-tracker', [
            'applications' => $applications,
            'stats' => $stats,
        ]);
    }

    /**
     * Update application status
     */
    public function updateStatus(Request $request, $applicationId)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:applied,shortlisted,interviewed,offered,rejected',
        ]);

        $application = JobApplication::findOrFail($applicationId);
        
        if ($application->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $application->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'application' => $application,
        ]);
    }
}
