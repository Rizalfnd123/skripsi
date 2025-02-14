<?php

namespace App\Http\Controllers\Auth;

use App\Models\Mitra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the login request and redirect based on user role.
     */
    public function login(Request $request)
{
    $credentials = $request->only('login', 'password'); // login bisa email atau username

    // Coba login sebagai User (menggunakan email)
    if (filter_var($credentials['login'], FILTER_VALIDATE_EMAIL)) {
        if (Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate(); // Regenerate session setelah login
            return $this->redirectUser(Auth::user());
        }
    }

    // Coba login sebagai Mitra (menggunakan username)
    if (Auth::guard('mitra')->attempt(['username' => $credentials['login'], 'password' => $credentials['password']])) {
        $request->session()->regenerate(); // Regenerate session setelah login

        return redirect('/mitra/dashboard');
    }

    return back()->withErrors(['login' => 'Username/email atau password salah']);
}


    // Redirect berdasarkan role users
    private function redirectUser($user)
    {
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

    // Redirect untuk mitra
    private function redirectMitra($mitra)
    {
        return redirect('/mitra/dashboard');
    }
}
