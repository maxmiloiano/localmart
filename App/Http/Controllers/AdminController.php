<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil semua data
        $users = User::all();
        $products = Product::with('seller')->get();
        $orders = Order::with(['buyer', 'details.product'])->get();

        return view('dashboard.admin', compact('users', 'products', 'orders'));
    }

    public function deleteUser($id)
    {
        User::where('id_user', $id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Pengguna berhasil dihapus.');
    }
}
