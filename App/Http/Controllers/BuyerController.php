<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuyerController extends Controller
{
    // ============================
    // DASHBOARD BUYER
    // ============================
    public function dashboard(Request $request)
    {
        $buyer = Auth::user();
        $buyerId = $buyer->id_user;

        // Ambil kategori
        $categories = DB::table('categories')->get();

        // Produk terbaru (tanpa filter)
        $products = DB::table('products')
            ->orderBy('id_product', 'DESC')
            ->limit(8)
            ->get();

        // Ambil pesanan buyer
        $ordersRaw = DB::table('orders')
            ->where('id_buyer', $buyerId)
            ->orderBy('id_order', 'DESC')
            ->get();

        $orders = $ordersRaw->map(function ($order) {
            return (object)[
                'id' => $order->id_order,
                'status' => $order->status_order,
                'total' => $order->total_harga,
                'created_at' => Carbon::parse($order->tanggal_order),
            ];
        });

        // Statistik
        $totalOrders = $orders->count();
        $processingOrders = $orders->where('status', 'diproses')->count();
        $shippingOrders = $orders->where('status', 'dikirim')->count();
        $completedOrders = $orders->where('status', 'selesai')->count();

        // Rekomendasi produk
        $recommendedProducts = DB::table('products')
            ->orderBy('id_product', 'DESC')
            ->limit(4)
            ->get();

        return view('dashboard.buyer', [
            'buyer' => $buyer,
            'products' => $products,
            'categories' => $categories,
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'processingOrders' => $processingOrders,
            'shippingOrders' => $shippingOrders,
            'completedOrders' => $completedOrders,
            'recommendedProducts' => $recommendedProducts
        ]);
    }

    // ======================================
    // HALAMAN PRODUK TERPISAH
    // ======================================
    public function products(Request $request)
    {
        $buyer = Auth::user();

        // Ambil kategori
        $categories = DB::table('categories')->get();

        // Produk dengan filter
        $products = DB::table('products')
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama_produk', 'like', "%{$request->search}%");
            })
            ->when($request->category, function ($q) use ($request) {
                $q->where('kategori', $request->category);
            })
            ->when($request->sort, function ($q) use ($request) {
                if ($request->sort == 'price_asc') $q->orderBy('harga', 'asc');
                if ($request->sort == 'price_desc') $q->orderBy('harga', 'desc');
            })
            ->orderBy('id_product', 'DESC')
            ->get();

        return view('dashboard.buyer_products', [
            'buyer' => $buyer,
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    // ======================================
    // HALAMAN DETAIL PRODUK BUYER
    // ======================================
    public function productDetail($id)
    {
        // Ambil produk berdasarkan id_product
        $product = DB::table('products')->where('id_product', $id)->first();

        if (!$product) {
        abort(404);
        }

        // Ambil data seller produk
        $seller = DB::table('users')->where('id_user', $product->id_seller)->first();

        return view('buyer.product_detail', [
        'product' => $product,
        'seller'  => $seller
     ]);
    }

}
