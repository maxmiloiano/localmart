<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Buyer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fa;
        }

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

        .content {
            padding: 30px;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px;
            width: 90%;
            margin: 15px auto;
            display: block;
            border-radius: 6px;
        }

        .logout-btn:hover {
            background-color: #b52d3a;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mb-4">Dashboard Seller</h4>

            <a href="{{ route('seller.dashboard') }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('products.index') }}">
                📦 Daftar Produk
            </a>

            <a href="{{ route('seller.chat') }}" class="active">
                💬 Chat Buyer
            </a>

            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit" class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 content">

            <h2 class="fw-bold mb-4">💬 Chat Buyer</h2>

            <div class="card p-3">

                @forelse ($chats as $chat)
                    <div class="p-2 border-bottom">
                        <b>{{ $chat->sender->name ?? 'Unknown' }}</b>
                        <small class="text-muted d-block">{{ $chat->waktu }}</small>
                        <p class="mt-1">{{ $chat->pesan }}</p>
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada pesan dari buyer.</p>
                @endforelse

            </div>
        </div>

    </div>
</div>
</body>
</html>
