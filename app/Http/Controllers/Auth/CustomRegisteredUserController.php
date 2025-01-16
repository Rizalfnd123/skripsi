<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterViewResponse;

class CustomRegisteredUserController extends Controller
{
    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the registration view.
     */
    public function create(Request $request): RegisterViewResponse
    {
        return app(RegisterViewResponse::class);
    }

    /**
     * Create a new registered user.
     */
    public function store(Request $request, CreatesNewUsers $creator)
    {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                config('fortify.username') => Str::lower($request->{config('fortify.username')}),
            ]);
        }

        event(new Registered($creator->create($request->all())));

        // Redirect ke halaman login tanpa otomatis login
        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
