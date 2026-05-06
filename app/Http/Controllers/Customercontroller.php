<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customerList = Customer::withCount('transaksis')->orderBy('created_at', 'desc')->get();
        return view('customer.index', compact('customerList'));
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customer.index')->with('success', 'Customer berhasil dihapus!');
    }
}