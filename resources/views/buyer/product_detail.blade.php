<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f5f7fa; }
        .sidebar {
            background-color: #007bff;
            min-height: 100vh;
            color: white;
            padding-top: 30px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 5px;
            margin: 4px 10px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #0056b3;
        }
        .product-img {
            width: 100%;
            max-height: 350px;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR BUYER -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mb-4">Buyer Menu</h4>

            <a href="{{ route('buyer.dashboard') }}">🏠 Dashboard</a>
            <a href="{{ route('buyer.products') }}" class="active">🛒 Produk</a>
            <a href="{{ route('buyer.dashboard') }}#orders-section">📦 Pesanan Saya</a>

            <form action="{{ route('logout') }}" method="GET">
                <button class="btn btn-danger w-100 mt-3">Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">

            <div class="card p-4">
                <div class="row">
                    <div class="col-md-5">
                        <img src="{{ asset('uploads/products/' . $product->gambar) }}" class="product-img">
                    </div>

                    <div class="col-md-7">
                        <h3>{{ $product->nama_produk }}</h3>
                        <h4 class="text-primary fw-bold">
                            Rp {{ number_format($product->harga) }}
                        </h4>

                        <p class="mt-3">{{ $product->deskripsi }}</p>
                        <p><b>Stok:</b> {{ $product->stok }}</p>
                        <p><b>Penjual:</b> {{ $seller->name }}</p>

                        <div class="mt-4 d-flex gap-2">
                            <a href="{{ route('buyer.chat', $seller->id_user) }}" class="btn btn-warning">
                                💬 Chat Seller
                            </a>

                            <a href="#" class="btn btn-success">
                                🛒 Tambah ke Keranjang
                            </a>

                            <a href="#" class="btn btn-primary">
                                ⚡ Beli Sekarang
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
