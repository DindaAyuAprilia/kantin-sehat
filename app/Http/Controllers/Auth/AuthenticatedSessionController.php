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
    // Menampilkan form login
    public function create(): View
    {
        return view('auth.login');
    }

    // Proses login
    public function store(LoginRequest $request): RedirectResponse
    {
        // Coba autentikasi
        $request->authenticate();
        
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Cek apakah status user 'berhenti'
        if ($user->status === 'berhenti') {
            // Logout user dan invalidate session
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redirect kembali ke login dengan pesan error
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.'
            ]);
        }

        // Regenerasi session jika status bukan 'berhenti'
        $request->session()->regenerate();

        // Redirect berdasarkan role
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('kasir.dashboard');
    }

    // Proses logout
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}