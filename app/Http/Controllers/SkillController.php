<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    // Tampilkan daftar skill milik user yang sedang login
    public function index()
    {
        $skills = Auth::user()->skills; // pastikan relasi 'skills' ada di model User
        return view('skill.index', compact('skills'));
    }

    // Tampilkan form tambah skill
    public function create()
    {
        return view('skill.create');
    }

    // Simpan skill baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_skill' => 'required|string|max:255',
            'level'      => 'nullable|string|max:50',
            'deskripsi'  => 'nullable|string',
        ]);

        $data['id_user'] = Auth::id();

        Skill::create($data);

        return redirect('/skills')->with('success', 'Skill berhasil ditambahkan!');
    }

 }
