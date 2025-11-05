<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $products = Product::orderBy('id_product', 'desc')->get();
        return view('products.index', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_category' => 'nullable|integer',
        ]);

        // Upload gambar baru (jika ada)
        $gambarName = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $gambarName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $gambarName);
        }

        Product::create([
            'id_seller' => auth()->check() ? auth()->user()->id_user : 1,
            'nama_produk' => $validated['nama_produk'],
            'kategori'    => $validated['kategori'],
            'deskripsi'   => $validated['deskripsi'] ?? null,
            'harga'       => $validated['harga'],
            'stok'        => $validated['stok'],
            'gambar'      => $gambarName,
            'id_category' => $validated['id_category'] ?? null,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Mengupdate produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Proses update gambar (jika user upload baru)
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar && file_exists(public_path('uploads/products/' . $product->gambar))) {
                unlink(public_path('uploads/products/' . $product->gambar));
            }

            $file = $request->file('gambar');
            $gambarName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $gambarName);

            $product->gambar = $gambarName;
        }

        // Update data lainnya
        $product->update([
            'nama_produk' => $validated['nama_produk'],
            'kategori'    => $validated['kategori'],
            'deskripsi'   => $validated['deskripsi'] ?? null,
            'harga'       => $validated['harga'],
            'stok'        => $validated['stok'],
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->gambar && file_exists(public_path('uploads/products/' . $product->gambar))) {
            unlink(public_path('uploads/products/' . $product->gambar));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
