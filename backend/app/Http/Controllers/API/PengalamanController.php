<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pengalaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengalamanController extends Controller
{
    public function index(Request $request)
    {
        $pengalaman = $request->user()->pengalaman()->orderBy('tanggal_mulai', 'desc')->get();
        
        return response()->json([
            'status' => true,
            'data' => $pengalaman
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'institusi' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'nullable|date|after:tanggal_mulai',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengalaman = $request->user()->pengalaman()->create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Experience added successfully',
            'data' => $pengalaman
        ], 201);
    }

    public function show(Pengalaman $pengalaman)
    {
        if ($pengalaman->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $pengalaman
        ]);
    }

    public function update(Request $request, Pengalaman $pengalaman)
    {
        if ($pengalaman->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'institusi' => 'sometimes|required|string|max:255',
            'posisi' => 'sometimes|required|string|max:255',
            'lokasi' => 'sometimes|required|string|max:255',
            'tanggal_mulai' => 'sometimes|required|date',
            'tanggal_akhir' => 'nullable|date|after:tanggal_mulai',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengalaman->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Experience updated successfully',
            'data' => $pengalaman
        ]);
    }

    public function destroy(Pengalaman $pengalaman)
    {
        if ($pengalaman->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $pengalaman->delete();

        return response()->json([
            'status' => true,
            'message' => 'Experience deleted successfully'
        ]);
    }
} 