<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('dashboard');
        }
        if (session()->has('customer_id')) {
            return redirect()->route('customer.produk');
        }
        return view('layouts.login');
    }

    public function login(Request $request)
    {
        $identifier = trim($request->input('username'));
        $password   = $request->input('password');

        if (empty($identifier) || empty($password)) {
            return back()->with('error', 'Username/email dan password wajib diisi!')->withInput();
        }

        // Cek apakah username/email terdaftar di tabel users
        $user = User::where('email', $identifier)
                    ->orWhere('username', $identifier)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Akun belum terdaftar')->withInput();
        }

        // Verifikasi password
        if ($user->password !== md5($password)) {
            return back()->with('error', 'Username/password salah')->withInput();
        }

        // Cek role untuk set session
        if ($user->role === 'admin') {
            session([
                'admin_id'   => $user->id,
                'admin_nama' => $user->nama,
                'admin_user' => $user->username,
            ]);
            return redirect()->route('dashboard')->with('success', 'Login berhasil! Selamat datang, ' . $user->nama);
        } elseif ($user->role === 'customer') {
            session([
                'customer_id'    => $user->id,
                'customer_nama'  => $user->nama,
                'customer_email' => $user->email,
            ]);
            return redirect()->route('customer.produk')->with('success', 'Login berhasil! Selamat datang, ' . $user->nama);
        }

        return back()->with('error', 'Username/password salah')->withInput();
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}