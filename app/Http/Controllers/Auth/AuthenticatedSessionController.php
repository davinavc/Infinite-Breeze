<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ambil role user
        $user = Auth::user();

        if ($user->role === 'Staff' && $user->staff && $user->staff->status === 'Resign') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sudah resign dan tidak dapat login.',
            ]);
        }

        if ($user->role == 'Admin') {
            return redirect()->route('dashboard.admin');
        } 
        elseif ($user->role == 'Staff') {
            return redirect()->route('dashboard.staff');
        }
        elseif ($user->role == 'Tenant') {
            if (!$user->tenant) {
                return redirect()->route('tenant.formData');
            } else {
                return redirect()->route('dashboard.tenant');
            }
        }

        return redirect()->intended('/');

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    
}
