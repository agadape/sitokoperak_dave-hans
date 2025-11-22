<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua pesanan milik user ini
        $orders = Order::with('items.produk.fotoProduk')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('guest.pages.dashboard', compact('user', 'orders'));
    }

    public function orderDetail(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('items.produk.fotoProduk');

        return view('guest.pages.order-detail', compact('order'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // username, email tidak boleh diubah (sesuai scope kelompok)
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
