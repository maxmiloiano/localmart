<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // SELLER: LIST CHAT (MENAMPILKAN DAFTAR BUYER)
// =====================================================
public function sellerChatList()
{
    $sellerId = Auth::user()->id_user;

    $buyers = Chat::where('id_sender', $sellerId)
        ->orWhere('id_receiver', $sellerId)
        ->with(['sender', 'receiver'])
        ->get()
        ->map(function ($chat) use ($sellerId) {
            return $chat->id_sender == $sellerId
                ? $chat->receiver
                : $chat->sender;
        })
        ->unique('id_user')
        ->values();

    return view('seller.chat_list', compact('buyers'));
}
    // SELLER: BUKA CHAT DENGAN BUYER
// =====================================================
public function sellerChatDetail($buyerId)
{
    $sellerId = Auth::user()->id_user;

    $buyer = User::where('id_user', $buyerId)->firstOrFail();

    $chats = Chat::where(function ($q) use ($sellerId, $buyerId) {
        $q->where('id_sender', $sellerId)
          ->where('id_receiver', $buyerId);
    })
    ->orWhere(function ($q) use ($sellerId, $buyerId) {
        $q->where('id_sender', $buyerId)
          ->where('id_receiver', $sellerId);
    })
    ->orderBy('waktu', 'asc')
    ->get();

    return view('seller.chat', compact('buyer', 'chats'));
}
    // =====================================================
    // BUYER: LIST CHAT (MENAMPILKAN DAFTAR SELLER)
    // =====================================================
    public function buyerChatList()
    {
        $buyerId = Auth::user()->id_user;

        // Ambil semua seller yang pernah chat dengan buyer
        $sellers = Chat::where('id_sender', $buyerId)
            ->orWhere('id_receiver', $buyerId)
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function ($chat) use ($buyerId) {
                return $chat->id_sender == $buyerId
                    ? $chat->receiver
                    : $chat->sender;
            })
            ->unique('id_user')
            ->values();

        return view('buyer.chat_list', compact('sellers'));
    }

    // =====================================================
    // BUYER: BUKA CHAT KE SELLER
    // (produk otomatis dikirim jika ada)
    // =====================================================
    public function buyerChat(Request $request, $sellerId)
    {
        $buyerId = Auth::user()->id_user;

        $seller = User::where('id_user', $sellerId)->firstOrFail();

        // Ambil chat buyer <-> seller
        $chats = Chat::where(function ($q) use ($buyerId, $sellerId) {
            $q->where('id_sender', $buyerId)
              ->where('id_receiver', $sellerId);
        })
        ->orWhere(function ($q) use ($buyerId, $sellerId) {
            $q->where('id_sender', $sellerId)
              ->where('id_receiver', $buyerId);
        })
        ->orderBy('waktu', 'asc')
        ->get();

        // ===============================
        // AUTO SEND PRODUK KE CHAT
        // ===============================
        if ($request->has('product')) {
            $product = Product::find($request->product);

            if ($product) {
                $exists = Chat::where('id_sender', $buyerId)
                    ->where('id_receiver', $sellerId)
                    ->where('pesan', 'like', "%{$product->nama_produk}%")
                    ->exists();

                // Kirim hanya jika belum pernah dikirim
                if (!$exists) {
                    Chat::create([
                        'id_sender'   => $buyerId,
                        'id_receiver' => $sellerId,
                        'pesan'       =>
                            "Halo kak 👋\n" .
                            "Saya ingin bertanya tentang produk berikut:\n\n" .
                            "📦 {$product->nama_produk}\n" .
                            "💰 Rp " . number_format($product->harga) . "\n\n" .
                            "Apakah masih tersedia?",
                        'waktu'       => now()
                    ]);
                }
            }
        }

        return view('buyer.chat', compact('seller', 'chats'));
    }

    // =====================================================
    // BUYER: KIRIM PESAN
    // =====================================================
    public function sendMessage(Request $request)
    {
        $request->validate([
            'id_receiver' => 'required|exists:users,id_user',
            'pesan'       => 'required|string'
        ]);

        Chat::create([
            'id_sender'   => Auth::user()->id_user,
            'id_receiver' => $request->id_receiver,
            'pesan'       => $request->pesan,
            'waktu'       => now()
        ]);

        return back();
    }

    // =====================================================
    // SELLER: LIHAT CHAT MASUK
    // =====================================================
    public function sellerChat()
    {
        $sellerId = Auth::user()->id_user;

        $chats = Chat::where('id_receiver', $sellerId)
            ->with('sender')
            ->orderBy('waktu', 'desc')
            ->get();

        return view('seller.chat', compact('chats'));
    }
}
