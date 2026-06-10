<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index()
    {
        $user = auth()->user();

        $experiences = $user->experiences()->orderByDesc('tanggal_mulai')->get();
        $educations = $user->educations()->orderByDesc('tanggal_mulai')->get();
        $skills = $user->skills()->get();

        // dd(compact('user', 'experiences', 'educations', 'skills'));
    
        return view('profile.show', compact('user', 'experiences', 'educations', 'skills'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.update-profile-information-form', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => ['required', Rule::in(['laki-laki', 'perempuan'])],
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->alamat = $validated['alamat'];
        $user->tanggal_lahir = $validated['tanggal_lahir'];
        $user->jenis_kelamin = $validated['jenis_kelamin'];

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
            }
            // Simpan foto baru
            $path = $request->file('photo')->store('profile_photos');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

}