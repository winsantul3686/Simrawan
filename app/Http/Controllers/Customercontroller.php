<?php

namespace App\Http\Controllers;

use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customerList = User::where('role', 'customer')->withCount('transaksis')->orderBy('created_at', 'desc')->get();
        return view('customer.index', compact('customerList'));
    }

    public function destroy($id)
    {
        User::where('role', 'customer')->findOrFail($id)->delete();
        return redirect()->route('customer.index')->with('success', 'Customer berhasil dihapus!');
    }
}