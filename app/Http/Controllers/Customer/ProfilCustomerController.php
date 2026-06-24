<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfilCustomerController extends Controller
{
    public function index()
    {
        $customer = User::findOrFail(session('customer_id'));
        return view('customer.profil', compact('customer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:100',
            'alamat'  => 'nullable|string',
        ]);

        $customer = User::findOrFail(session('customer_id'));
        $customer->update([
            'nama'    => $request->nama,
            'no_telp' => $request->no_telp,
            'email'   => $request->email,
            'alamat'  => $request->alamat,
        ]);

        session(['customer_nama' => $request->nama]);

        return redirect()->route('customer.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password_lama'   => 'required',
            'password_baru'   => 'required|min:6',
            'konfirmasi_baru' => 'required|same:password_baru',
        ]);

        $customer = User::findOrFail(session('customer_id'));

        if ($customer->password !== md5($request->password_lama)) {
            return redirect()->route('customer.profil')
                ->with('error', 'Password lama salah!')
                ->withFragment('reset');
        }

        $customer->update(['password' => md5($request->password_baru)]);

        return redirect()->route('customer.profil')->with('success', 'Password berhasil diubah!');
    }
}