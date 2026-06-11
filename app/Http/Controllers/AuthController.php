<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Memproses data dari form login
    public function login(Request $request)
    {
        // Validasi inputan
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Proses pengecekan ke database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role untuk 4 POV[cite: 1]
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'supervisor') {
                return redirect()->route('supervisor.dashboard');
            } elseif ($role === 'personel') {
                return redirect()->route('personel.dashboard');
            } elseif ($role === 'klien') {
                return redirect()->route('klien.dashboard');
            }
        }

        // Jika gagal login, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}