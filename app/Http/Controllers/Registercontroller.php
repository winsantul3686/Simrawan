<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

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
            'no_telp'            => 'required|string|max:20',
            'email'              => 'required|email|unique:customers,email',
            'alamat'             => 'required|string',
            'password'           => 'required|min:6',
            'konfirmasi_password'=> 'required|same:password',
            'setuju'             => 'accepted',
        ], [
            'email.unique'              => 'Email sudah terdaftar!',
            'konfirmasi_password.same'  => 'Konfirmasi password tidak cocok!',
            'setuju.accepted'           => 'Anda harus menyetujui syarat dan ketentuan!',
        ]);

        Customer::create([
            'nama'     => $request->nama,
            'no_telp'  => $request->no_telp,
            'email'    => $request->email,
            'alamat'   => $request->alamat,
            'password' => md5($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}