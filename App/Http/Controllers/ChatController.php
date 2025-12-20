<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // =========================
    // BUYER buka chat ke seller
    // =========================
    public function buyerChat($sellerId)
    {
        $buyerId = Auth::user()->id_user;

        $seller = User::where('id_user', $sellerId)->firstOrFail();

        $chats = Chat::where(function ($q) use ($buyerId, $sellerId) {
            $q->where('id_sender', $buyerId)
              ->where('id_receiver', $sellerId);
        })->orWhere(function ($q) use ($buyerId, $sellerId) {
            $q->where('id_sender', $sellerId)
              ->where('id_receiver', $buyerId);
        })
        ->orderBy('waktu', 'asc')
        ->get();

        return view('buyer.chat', compact('seller', 'chats'));
    }

    // =========================
    // BUYER kirim pesan
    // =========================
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

    // =========================
    // SELLER lihat pesan masuk
    // =========================
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
