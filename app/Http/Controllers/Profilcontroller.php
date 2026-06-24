<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        $admin = User::findOrFail(session('admin_id'));
        return view('profil.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:100',
            'alamat'  => 'nullable|string',
        ]);

        $admin = User::findOrFail(session('admin_id'));
        $admin->update([
            'nama'    => $request->nama,
            'no_telp' => $request->no_telp,
            'email'   => $request->email,
            'alamat'  => $request->alamat,
        ]);

        // Update session nama
        session(['admin_nama' => $request->nama]);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password_lama'    => 'required',
            'password_baru'    => 'required|min:6',
            'konfirmasi_baru'  => 'required|same:password_baru',
        ]);

        $admin = User::findOrFail(session('admin_id'));

        if ($admin->password !== md5($request->password_lama)) {
            return redirect()->route('profil.index')
                ->with('error', 'Password lama salah!')
                ->withFragment('reset');
        }

        $admin->update(['password' => md5($request->password_baru)]);

        return redirect()->route('profil.index')->with('success', 'Password berhasil direset');
    }
}