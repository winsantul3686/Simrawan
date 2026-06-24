<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('layouts.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'               => 'required|string|max:100',
            'username'           => 'required|string|max:100|unique:users,username',
            'no_telp'            => 'required|string|max:20',
            'email'              => 'required|email|unique:users,email',
            'alamat'             => 'required|string',
            'password'           => 'required|min:6',
            'konfirmasi_password'=> 'required|same:password',
            'setuju'             => 'accepted',
        ], [
            'username.unique'           => 'Username sudah digunakan!',
            'email.unique'              => 'Email sudah terdaftar!',
            'konfirmasi_password.same'  => 'Konfirmasi password tidak cocok!',
            'setuju.accepted'           => 'Anda harus menyetujui syarat dan ketentuan!',
        ]);

        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'no_telp'  => $request->no_telp,
            'email'    => $request->email,
            'alamat'   => $request->alamat,
            'password' => md5($request->password),
            'role'     => 'customer',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}