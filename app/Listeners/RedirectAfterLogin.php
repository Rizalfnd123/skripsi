<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;

class RedirectAfterLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = Auth::user();

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                $redirectTo = '/admin';
                break;
            case 'dosen':
                $redirectTo = '/dosen';
                break;
            case 'mahasiswa':
                $redirectTo = '/mahasiswa';
                break;
            default:
                $redirectTo = '/umum';
                break;
        }

        // Sesuaikan redirect
        session(['url.intended' => $redirectTo]);
    }
}
