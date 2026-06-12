<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeBuilderController extends Controller
{
    /**
     * Display the resume builder page
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('career-tools.resume-builder', [
            'user' => $user,
        ]);
    }

    /**
     * Generate resume using AI
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string',
            'skills' => 'required|string',
            'experience' => 'required|string',
            'tone' => 'nullable|string|in:professional,casual,creative',
        ]);

        try {
            // Placeholder for AI resume generation via Cohere API
            $resumeContent = "Resume generated from input:\n";
            $resumeContent .= "Job Title: " . $validated['job_title'] . "\n";
            $resumeContent .= "Skills: " . $validated['skills'] . "\n";
            $resumeContent .= "Experience: " . $validated['experience'];

            return response()->json([
                'success' => true,
                'resume' => $resumeContent,
                'message' => 'Resume generated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating resume: ' . $e->getMessage()
            ], 500);
        }
    }
}
