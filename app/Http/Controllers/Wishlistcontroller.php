<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistList = Wishlist::with(['customer', 'stokIkan'])
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('wishlist.index', compact('wishlistList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Belum Tersedia,Tersedia',
        ]);

        $wishlist = Wishlist::findOrFail($id);
        $wishlist->update([
            'status' => $request->status,
            'is_read' => false
        ]);

        return redirect()->route('wishlist.index')->with('success', 'Status wishlist berhasil diperbarui!');
    }
}