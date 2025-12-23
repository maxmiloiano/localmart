<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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

<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR SELLER -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mb-4">Dashboard Seller</h4>

            <a href="{{ route('seller.dashboard') }}">🏠 Dashboard</a>
            <a href="{{ route('products.index') }}">📦 Daftar Produk</a>
            <a href="{{ route('seller.chat.list') }}" class="active">💬 Chat Seller</a>

            <form action="{{ route('logout') }}" method="GET">
                <button class="btn btn-danger w-100 mt-3">Logout</button>
            </form>
        </div>

        <!-- MAIN -->
        <div class="col-md-9 col-lg-10 p-4">
            <h4 class="fw-bold mb-3">💬 Daftar Chat Buyer</h4>

            <div class="card p-3">
                <div class="list-group">
                    @forelse($buyers as $buyer)
                        <a href="{{ route('seller.chat.detail', $buyer->id_user) }}"
                           class="list-group-item list-group-item-action">
                            👤 <b>{{ $buyer->name }}</b>
                        </a>
                    @empty
                        <p class="text-muted text-center mb-0">
                            Belum ada chat dari buyer
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
