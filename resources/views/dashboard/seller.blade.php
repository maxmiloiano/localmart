<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
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
        .sidebar a:hover, .sidebar a.active {
            background-color: #0056b3;
        }
        .content {
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mb-4">Dashboard Seller</h4>

            <a href="{{ route('seller.dashboard') }}" 
                class="{{ request()->is('seller/dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('products.index') }}" 
                class="{{ request()->is('products') ? 'active' : '' }}">
                📦 Daftar Produk
            </a>
            <a href="{{ route('seller.chat') }}" class="{{ request()->is('seller/chat') ? 'active' : '' }}">
                💬 Chat Seller
            </a>

            

            <form action="{{ route('logout') }}" method="GET" class="mt-4">
                @csrf
                <button type="submit" class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 content">
            <h3 class="fw-bold">Selamat Datang, {{ $seller->name }} 👋</h3>
            <p>Gunakan menu di kiri untuk mengelola produk Anda.</p>

            <div class="row g-3 mt-4">
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h6 class="text-muted">Total Produk</h6>
                        <h3 class="fw-bold text-primary">{{ $totalProducts }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h6 class="text-muted">Produk Tersedia</h6>
                        <h3 class="fw-bold text-success">{{ $availableProducts }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h6 class="text-muted">Produk Habis</h6>
                        <h3 class="fw-bold text-danger">{{ $outOfStockProducts }}</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
