<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('dashboard');
        }
        return view('layouts.login');
    }

    public function login(Request $request)
    {
        $username = trim($request->input('username'));
        $password = $request->input('password');

        if (empty($username) || empty($password)) {
            return back()->with('error', 'Username dan password wajib diisi!')->withInput();
        }

        $admin = Admin::where('username', $username)
                      ->where('password', md5($password))
                      ->first();

        if (!$admin) {
            return back()->with('error', 'Username atau password salah!')->withInput();
        }

        session([
            'admin_id'   => $admin->id,
            'admin_nama' => $admin->nama,
            'admin_user' => $admin->username,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}