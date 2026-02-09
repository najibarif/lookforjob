<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $skills = $request->user()->skills()->orderBy('nama_skill')->get();
        
        return response()->json([
            'status' => true,
            'data' => $skills
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_skill' => 'required|string|max:255',
            'level' => 'required|in:Beginner,Intermediate,Advanced,Expert',
            'sertifikasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['nama_skill', 'level']);

        if ($request->hasFile('sertifikasi')) {
            $path = $request->file('sertifikasi')->store('sertifikasi', 'public');
            $data['sertifikasi'] = $path;
        }

        $skill = $request->user()->skills()->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Skill added successfully',
            'data' => $skill
        ], 201);
    }

    public function show(Skill $skill)
    {
        if ($skill->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $skill
        ]);
    }

    public function update(Request $request, Skill $skill)
    {
        if ($skill->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_skill' => 'sometimes|required|string|max:255',
            'level' => 'sometimes|required|in:Beginner,Intermediate,Advanced,Expert',
            'sertifikasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['nama_skill', 'level']);

        if ($request->hasFile('sertifikasi')) {
            // Delete old file if exists
            if ($skill->sertifikasi) {
                Storage::disk('public')->delete($skill->sertifikasi);
            }
            
            $path = $request->file('sertifikasi')->store('sertifikasi', 'public');
            $data['sertifikasi'] = $path;
        }

        $skill->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Skill updated successfully',
            'data' => $skill
        ]);
    }

    public function destroy(Skill $skill)
    {
        if ($skill->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        if ($skill->sertifikasi) {
            Storage::disk('public')->delete($skill->sertifikasi);
        }

        $skill->delete();

        return response()->json([
            'status' => true,
            'message' => 'Skill deleted successfully'
        ]);
    }
} 