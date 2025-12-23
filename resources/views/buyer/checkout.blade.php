<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
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

        .sidebar a.active {
            background-color: #0056b3;
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .qty-box button {
            width: 32px;
            height: 32px;
            border: 1px solid #ccc;
            background: #fff;
        }

        .qty-box input {
            width: 45px;
            text-align: center;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container-fluid">
<div class="row">

    <!-- SIDEBAR -->
    <div class="col-md-3 col-lg-2 sidebar">
        <h4 class="text-center mb-4">Buyer Menu</h4>

        <a href="{{ route('buyer.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('buyer.products') }}">📦 Produk</a>
        <a href="{{ route('buyer.chat.list') }}">💬 Chat Buyer</a>
        <a href="{{ route('buyer.cart') }}" class="active">🛒 Keranjang</a>
        <a href="{{ route('buyer.dashboard') }}#orders-section">📦 Pesanan Saya</a>

        <form action="{{ route('logout') }}" method="GET">
            <button class="btn btn-danger w-100 mt-3">Logout</button>
        </form>
    </div>

<!-- CONTENT -->
    <div class="col-md-9 col-lg-10 p-4">
        <!-- BACK BUTTON -->
                <a href="{{ route('buyer.cart') }}"
                class="btn btn-secondary mb-3">
                    ⬅ 
                </a>
        <h3 class="fw-bold mb-4">📦 Checkout</h3>

<form action="{{ route('buyer.checkout.process') }}" method="POST">
@csrf

<!-- DATA PENERIMA -->
<div class="card mb-3">
    <div class="card-header fw-bold">Alamat Pengiriman</div>
    <div class="card-body">
        <input class="form-control mb-2" name="receiver" placeholder="Nama Penerima" required>
        <input class="form-control mb-2" name="phone" placeholder="Nomor Telepon" required>
        <textarea class="form-control" name="address" placeholder="Alamat Lengkap" required></textarea>
    </div>
</div>

<!-- PRODUK -->
<div class="card mb-3">
    <div class="card-header fw-bold">Produk Dipesan</div>
    @foreach($cartItems as $sellerId => $items)
<div class="card mb-3">

    <!-- SELLER -->
    <div class="card-header bg-light fw-bold">
        ⭐ {{ $items->first()->seller_name }}
    </div>

    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('uploads/products/' . $item->gambar) }}"
                                 class="product-img">
                            <div>
                                <b>{{ $item->nama_produk }}</b>
                            </div>
                        </div>
                    </td>

                    <td>
                        Rp {{ number_format($item->harga) }}
                    </td>

                    <td>
                        {{ $item->qty }}
                    </td>

                    <td class="fw-bold text-danger">
                        Rp {{ number_format($item->harga * $item->qty) }}
                    </td>
                </tr>

                <!-- Hidden cart id -->
                <input type="hidden" name="cart_ids[]" value="{{ $item->id_cart }}">
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach


<!-- CATATAN -->
<div class="card mb-3">
    <div class="card-header fw-bold">Catatan untuk Seller</div>
    <div class="card-body">
        <textarea class="form-control" name="note"></textarea>
    </div>
</div>

<!-- PENGIRIMAN -->
<div class="card mb-3">
    <div class="card-header fw-bold">Opsi Pengiriman</div>
    <div class="card-body">
        <select class="form-select" name="shipping">
            <option value="JNE">JNE</option>
            <option value="J&T">J&T</option>
            <option value="SiCepat">SiCepat</option>
            <option value="Antar sendiri">Antar Sendiri</option>
        </select>
    </div>
</div>

<!-- PEMBAYARAN -->
<div class="card mb-3">
    <div class="card-header fw-bold">Metode Pembayaran</div>
    <div class="card-body">
        <select class="form-select" name="payment">
            <option value="COD">COD</option>
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="E-Wallet">E-Wallet</option>
        </select>
    </div>
</div>

<!-- RINGKASAN -->
<div class="card mb-3">
    <div class="card-body text-end">
        <h5>Total Pembayaran: 
            <span class="text-danger">
                Rp {{ number_format($totalHarga) }}
            </span>
        </h5>
    </div>
</div>

<button class="btn btn-success w-100">✔ Buat Pesanan</button>
</form>

</div>
</body>
</html>
