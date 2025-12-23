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

        .chat-item {
            margin-bottom: 12px;
        }

        .chat-item small {
            font-size: 12px;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR SELLER -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mb-4">Dashboard Seller</h4>

            <a href="{{ route('seller.dashboard') }}">🏠 Dashboard</a>
            <a href="{{ route('products.index') }}">📦 Daftar Produk</a>
            <a href="{{ route('seller.chat.list') }}" class="active">💬 Chat Seller</a>

            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit" class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 content">
            <!-- BACK BUTTON -->
                <a href="{{ route('seller.chat.list') }}"
                class="btn btn-secondary mb-3">
                    ⬅ 
                </a>
            <h2 class="fw-bold mb-4">💬 Chat dengan {{ $buyer->name }}</h2>

            <!-- CHAT AREA -->
            <div class="card p-3 mb-3">

                @forelse ($chats as $chat)
                    <div class="chat-item border-bottom pb-2">
                        <b>{{ $chat->sender->name }}</b>
                        <p class="mb-1">{{ $chat->pesan }}</p>
                        <small class="text-muted">{{ $chat->waktu }}</small>
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada pesan dari buyer.</p>
                @endforelse

            </div>

            <!-- FORM BALAS PESAN -->
            <form action="{{ route('chat.send') }}" method="POST">
                @csrf
                <input type="hidden" name="id_receiver" value="{{ $buyer->id_user }}">

                <div class="input-group">
                    <input type="text"
                           name="pesan"
                           class="form-control"
                           placeholder="Balas pesan..."
                           required>
                    <button class="btn btn-primary">Kirim</button>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
</html>
