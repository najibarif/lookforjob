<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendidikanController extends Controller
{
    public function index(Request $request)
    {
        $pendidikan = $request->user()->pendidikan()->orderBy('tanggal_mulai', 'desc')->get();
        
        return response()->json([
            'status' => true,
            'data' => $pendidikan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'institusi' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA/SMK,D1,D2,D3,D4,S1,S2,S3',
            'jurusan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'nullable|date|after:tanggal_mulai',
            'ipk' => 'nullable|numeric|between:0,4.00',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pendidikan = $request->user()->pendidikan()->create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Education added successfully',
            'data' => $pendidikan
        ], 201);
    }

    public function show(Pendidikan $pendidikan)
    {
        if ($pendidikan->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $pendidikan
        ]);
    }

    public function update(Request $request, Pendidikan $pendidikan)
    {
        if ($pendidikan->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'institusi' => 'sometimes|required|string|max:255',
            'jenjang' => 'sometimes|required|in:SD,SMP,SMA/SMK,D1,D2,D3,D4,S1,S2,S3',
            'jurusan' => 'sometimes|required|string|max:255',
            'lokasi' => 'sometimes|required|string|max:255',
            'tanggal_mulai' => 'sometimes|required|date',
            'tanggal_akhir' => 'nullable|date|after:tanggal_mulai',
            'ipk' => 'nullable|numeric|between:0,4.00',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pendidikan->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Education updated successfully',
            'data' => $pendidikan
        ]);
    }

    public function destroy(Pendidikan $pendidikan)
    {
        if ($pendidikan->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $pendidikan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Education deleted successfully'
        ]);
    }
} 