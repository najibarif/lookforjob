<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;

class RegisteredUserController
{
    public function store(Request $request, CreateNewUser $creator)
    {
        $user = $creator->create($request->all());

        // Login user setelah register
        auth()->login($user);

        // Redirect ke halaman profile
        return redirect()->route('login');
    }
}