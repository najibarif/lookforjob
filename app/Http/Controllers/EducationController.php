<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Auth::user()->educations()->orderByDesc('tanggal_mulai')->get();
        return view('education.index', compact('educations'));
    }

    public function create()
    {
        return view('education.create');
    }

        public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_user' => 'required|integer|exists:users,id', // pastikan id_user ada di tabel users
            'institusi' => 'required|string|max:255',
            'jenjang' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'ipk' => 'nullable|numeric|between:0,4.00',
            'deskripsi' => 'nullable|string',
        ]);

        // Simpan data
        Education::create($validatedData);

        return redirect('/pendidikan')->with('success', 'Data pendidikan berhasil disimpan.');
    }


    public function edit(Education $education)
    {
        $this->authorize('update', $education);
        return view('education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $this->authorize('update', $education);
        $data = $request->validate([
            'institusi'      => 'required|string|max:255',
            'jurusan'        => 'nullable|string|max:255',
            'tanggal_mulai'  => 'required|date',
            'tanggal_akhir'  => 'nullable|date',
            'deskripsi'      => 'nullable|string',
        ]);
        $education->update($data);
        return redirect()->route('education.index')->with('success', 'Pendidikan berhasil diubah!');
    }

    public function destroy(Education $education)
    {
        $this->authorize('delete', $education);
        $education->delete();
        return redirect()->route('education.index')->with('success', 'Pendidikan berhasil dihapus!');
    }
}