<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Buyer</title>

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

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0056b3;
        }

        .chat-card {
            border-radius: 8px;
            transition: 0.2s;
        }

        .chat-card:hover {
            background-color: #f1f5ff;
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
            <a href="{{ route('buyer.products') }}">🛒 Produk</a>
            <a href="{{ route('buyer.chat.list') }}" class="active">💬 Chat Buyer</a>
            <a href="{{ route('buyer.cart') }}">🛒 Keranjang</a>
            <a href="{{ route('buyer.dashboard') }}#orders-section">📦 Pesanan Saya</a>

            <form action="{{ route('logout') }}" method="GET">
                <button class="btn btn-danger w-100 mt-3">Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">

            <h4 class="fw-bold mb-3">💬 Daftar Chat Seller</h4>
            <p class="text-muted">Pilih seller untuk melanjutkan percakapan</p>

            <div class="card p-3">
                <div class="list-group">
                    @forelse($sellers as $seller)
                        <a href="{{ route('buyer.chat', $seller->id_user) }}"
                           class="list-group-item list-group-item-action chat-card">
                            👤 <b>{{ $seller->name }}</b>
                        </a>
                    @empty
                        <p class="text-center text-muted mb-0">
                            Belum ada chat dengan seller
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
