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

        $categories = DB::table('categories')->get();

        $products = DB::table('products')
            ->orderBy('id_product', 'DESC')
            ->limit(8)
            ->get();

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

        $totalOrders      = $orders->count();
        $processingOrders = $orders->where('status', 'diproses')->count();
        $shippingOrders   = $orders->where('status', 'dikirim')->count();
        $completedOrders  = $orders->where('status', 'selesai')->count();

        $recommendedProducts = DB::table('products')
            ->orderBy('id_product', 'DESC')
            ->limit(4)
            ->get();

        return view('dashboard.buyer', compact(
            'buyer',
            'products',
            'categories',
            'orders',
            'totalOrders',
            'processingOrders',
            'shippingOrders',
            'completedOrders',
            'recommendedProducts'
        ));
    }

    // ============================
    // LIST PRODUK
    // ============================
    public function products(Request $request)
    {
        $buyer = Auth::user();
        $categories = DB::table('categories')->get();

        $products = DB::table('products')
            ->when($request->search, fn ($q) =>
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
            )
            ->when($request->category, fn ($q) =>
                $q->where('kategori', $request->category)
            )
            ->orderBy('id_product', 'DESC')
            ->get();

        return view('dashboard.buyer_products', compact(
            'buyer',
            'products',
            'categories'
        ));
    }

    // ============================
    // DETAIL PRODUK
    // ============================
    public function productDetail($id)
    {
        $product = DB::table('products')
            ->where('id_product', $id)
            ->first();

        if (!$product) abort(404);

        $seller = DB::table('users')
            ->where('id_user', $product->id_seller)
            ->first();

        return view('buyer.product_detail', compact(
            'product',
            'seller'
        ));
    }

    // ============================
    // KERANJANG
    // ============================
    public function cart()
    {
        $buyer = Auth::user();
        $buyerId = $buyer->id_user;

        $cartItems = DB::table('carts')
            ->join('products', 'carts.id_product', '=', 'products.id_product')
            ->join('users', 'products.id_seller', '=', 'users.id_user')
            ->where('carts.id_buyer', $buyerId)
            ->select(
                'carts.id_cart',
                'carts.qty',
                'products.nama_produk',
                'products.harga',
                'products.gambar',
                'users.id_user as seller_id',
                'users.name as seller_name'
            )
            ->get()
            ->groupBy('seller_id');

        $totalHarga = 0;
        foreach ($cartItems as $items) {
            foreach ($items as $item) {
                $totalHarga += $item->harga * $item->qty;
            }
        }

        return view('buyer.cart', compact(
            'buyer',
            'cartItems',
            'totalHarga'
        ));
    }

    // ============================
    // TAMBAH KE KERANJANG
    // ============================
    public function addToCart($productId)
    {
        $buyerId = Auth::user()->id_user;

        $cart = DB::table('carts')
            ->where('id_buyer', $buyerId)
            ->where('id_product', $productId)
            ->first();

        if ($cart) {
            DB::table('carts')
                ->where('id_cart', $cart->id_cart)
                ->increment('qty');
        } else {
            DB::table('carts')->insert([
                'id_buyer' => $buyerId,
                'id_product' => $productId,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('buyer.cart');
    }

    // ============================
    // UPDATE QTY
    // ============================
    public function updateQty(Request $request, $id)
    {
        DB::table('carts')
            ->where('id_cart', $id)
            ->update([
                'qty' => max(1, (int)$request->qty),
                'updated_at' => now()
            ]);

        return redirect()->route('buyer.cart');
    }

    // ============================
    // HAPUS ITEM
    // ============================
    public function deleteItem($id)
    {
        DB::table('carts')->where('id_cart', $id)->delete();
        return redirect()->route('buyer.cart');
    }

    // ============================
    // CHECKOUT (GROUP BY SELLER ✅)
    // ============================
    public function checkout(Request $request)
    {
        $buyer = Auth::user();

        $cartItems = DB::table('carts')
            ->join('products', 'carts.id_product', '=', 'products.id_product')
            ->join('users', 'products.id_seller', '=', 'users.id_user')
            ->whereIn('carts.id_cart', $request->cart_ids ?? [])
            ->select(
                'carts.id_cart',
                'carts.qty',
                'products.nama_produk',
                'products.harga',
                'products.gambar',
                'users.id_user as seller_id',
                'users.name as seller_name'
            )
            ->get()
            ->groupBy('seller_id'); // ✅ BENAR

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart')
                ->with('error', 'Pilih produk terlebih dahulu');
        }

        $totalHarga = 0;
        foreach ($cartItems as $items) {
            foreach ($items as $item) {
                $totalHarga += $item->harga * $item->qty;
            }
        }

        return view('buyer.checkout', compact(
            'buyer',
            'cartItems',
            'totalHarga'
        ));
    }
}
