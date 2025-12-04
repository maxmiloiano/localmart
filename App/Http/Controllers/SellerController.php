<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard()
    {
        $seller = Auth::user();

        // Ambil semua produk yang dimiliki seller ini
        $products = Product::where('id_seller', $seller->id)->get();

        // Hitung total dan stok
        $totalProducts = $products->count();
        $availableProducts = $products->where('stok', '>', 0)->count();
        $outOfStockProducts = $products->where('stok', '<=', 0)->count();

        return view('dashboard.seller', compact(
            'seller',
            'totalProducts',
            'availableProducts',
            'outOfStockProducts'
        ));
    }
}
