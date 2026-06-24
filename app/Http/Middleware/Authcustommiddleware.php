<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCustomMiddleware
{
    public function handle(Request $request, Closure $next, string $role = null)
    {
        // Cek sudah login (admin atau customer)
        $isAdmin    = session()->has('admin_id');
        $isCustomer = session()->has('customer_id');

        if (!$isAdmin && !$isCustomer) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Kalau route butuh role tertentu
        if ($role === 'admin' && !$isAdmin) {
            return redirect()->route('beranda')->with('error', 'Akses ditolak.');
        }

        if ($role === 'customer' && !$isCustomer) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}