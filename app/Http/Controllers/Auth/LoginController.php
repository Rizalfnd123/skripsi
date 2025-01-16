<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the login request and redirect based on user role.
     */
    public function login(Request $request)
    {
        // Validasi login Fortify
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah']);
        }

        // Redirect berdasarkan role
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'dosen':
                return redirect('/dosen');
            case 'mahasiswa':
                return redirect('/mahasiswa');
            default:
                return redirect('/umum');
        }
    }
}
