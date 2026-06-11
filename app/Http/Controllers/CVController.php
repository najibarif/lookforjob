<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CohereService;

class CVController extends Controller
{
    protected $cohereService;

    public function __construct(CohereService $cohereService)
    {
        $this->cohereService = $cohereService;
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_input' => 'required|string',
        ]);

        // --- Mode: Save Only (user edited HTML manually and wants to save) ---
        if ($request->input('user_input') === '__SAVE_ONLY__' && $request->has('cv_html')) {
            if (Auth::check()) {
                $user = Auth::user();
                $user->cv_html = $request->input('cv_html');
                $user->save();
            }
            return response()->json(['success' => true, 'cv' => $request->input('cv_html')]);
        }

        // --- Mode: Generate CV via AI ---
        try {
            $cvContent = $this->cohereService->generateCV($request->input('user_input'));

            // Simpan CV ke profil user yang sedang login
            if (Auth::check()) {
                $user = Auth::user();
                $user->cv_html = $cvContent;
                $user->save();
            }

            return response()->json([
                'success' => true,
                'cv'      => $cvContent,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}