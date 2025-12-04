<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // SELLER melihat chat masuk
    public function sellerChat()
    {
        $seller = Auth::user();

        $chats = Chat::where('id_receiver', $seller->id)
            ->orderBy('waktu', 'DESC')
            ->get();

        return view('seller.chat', compact('chats'));
    }

    // BUYER mengirim pesan
    public function sendMessage(Request $request)
    {
        $request->validate([
            'seller_id' => 'required',
            'pesan'     => 'required'
        ]);

        Chat::create([
            'id_sender'   => Auth::id(),
            'id_receiver' => $request->seller_id,
            'pesan'       => $request->pesan,
            'waktu'       => now()
        ]);

        return back()->with('success', 'Pesan berhasil dikirim');
    }
}
