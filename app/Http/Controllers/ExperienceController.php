<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $experiences = Experience::where('id_user', Auth::id())->get();
        return view('experience.index', compact('experiences'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'institusi'      => 'required|string|max:255',
            'posisi'         => 'required|string|max:255',
            'lokasi'         => 'nullable|string|max:255',
            'tanggal_mulai'  => 'required|date',
            'tanggal_akhir'  => 'nullable|date',
            'deskripsi'      => 'nullable|string',
        ]);

        $data['id_user'] = Auth::id();
        Experience::create($data);

        return redirect('/pengalaman')->with('success', 'Pengalaman berhasil ditambahkan!');
    }
}