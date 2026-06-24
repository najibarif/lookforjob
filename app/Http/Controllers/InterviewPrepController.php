<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewPrepController extends Controller
{
    /**
     * Display the interview prep page
     */
    public function index()
    {
        return view('career-tools.interview-prep');
    }

    /**
     * Generate interview questions based on job role
     */
    public function generateQuestions(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string',
            'company' => 'nullable|string',
            'experience_level' => 'required|string|in:junior,mid,senior',
            'question_count' => 'nullable|integer|min:1|max:20',
        ]);

        try {
            $questionCount = $validated['question_count'] ?? 5;
            
            // Placeholder questions for demo
            $questions = [
                'Tell us about yourself and your professional background.',
                'What attracted you to this role and company?',
                'Describe a challenging project you worked on. How did you overcome it?',
                'How do you stay updated with industry trends?',
                'What are your greatest strengths and weaknesses?',
                'Where do you see yourself in 5 years?',
                'Describe a time you faced conflict in a team. How did you resolve it?',
                'What is your approach to problem-solving?',
                'Tell us about a time you failed. What did you learn?',
                'Why should we hire you for this position?',
            ];

            $selectedQuestions = array_slice($questions, 0, $questionCount);

            return response()->json([
                'success' => true,
                'job_title' => $validated['job_title'],
                'company' => $validated['company'] ?? 'Not specified',
                'questions' => $selectedQuestions,
                'message' => 'Interview questions generated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating questions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process voice interview interaction
     */
    public function processVoice(Request $request, \App\Services\CohereService $cohereService)
    {
        $validated = $request->validate([
            'job_title' => 'required|string',
            'user_message' => 'required|string',
            'chat_history' => 'nullable|array',
            'language' => 'nullable|string',
        ]);

        try {
            $language = $validated['language'] ?? 'id-ID';
            $response = $cohereService->processVoiceInterview(
                $validated['job_title'],
                $validated['chat_history'] ?? [],
                $validated['user_message'],
                $language
            );

            return response()->json([
                'success' => true,
                'ai_response' => $response['text'] ?? '',
                'chat_history' => $response['chat_history'] ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing voice: ' . $e->getMessage()
            ], 500);
        }
    }

    public function transcribe(Request $request)
    {
        $request->validate([
            'audio' => 'required|file',
            'language' => 'nullable|string',
        ]);

        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'GEMINI_API_KEY belum dikonfigurasi di file .env untuk transkripsi audio cross-browser. Silakan isi konfigurasi tersebut.'
            ]);
        }

        $audioFile = $request->file('audio');
        $language = $request->input('language', 'id-ID');
        $langName = strpos($language, 'id') !== false ? 'Indonesian' : 'English';
        
        $audioBase64 = base64_encode(file_get_contents($audioFile->getRealPath()));

        // Use HTTP client to send to Gemini API
        $response = \Illuminate\Support\Facades\Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "Please transcribe the following audio precisely in $langName. Respond with ONLY the exact transcript text, nothing else. Do not add markdown or quotes."
                        ],
                        [
                            'inline_data' => [
                                'mime_type' => 'audio/webm',
                                'data' => $audioBase64
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            return response()->json([
                'success' => true,
                'text' => trim($text)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menerjemahkan audio: ' . $response->body()
        ]);
    }
}
