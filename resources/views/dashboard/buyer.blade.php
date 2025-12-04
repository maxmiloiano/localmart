<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>

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
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            width: 90%;
            margin: 15px auto;
            border-radius: 6px;
            border: none;
        }
        .product-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mb-4">Dashboard Buyer</h4>

            <a href="{{ route('buyer.dashboard') }}" class="{{ request()->is('buyer/dashboard') ? 'active' : '' }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('buyer.products') }}" class="{{ request()->is('buyer/products') ? 'active' : '' }}">
                🛒 Produk
            </a>

            <a href="#orders-section">
                📦 Pesanan Saya
            </a>

            <form action="{{ route('logout') }}" method="GET"> 
                <button class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">

            <h3 class="fw-bold">Selamat Datang, {{ $buyer->name }} 👋</h3>
            <p>Senang melihat Anda kembali! Mulai belanja sekarang.</p>

            <!-- Statistik -->
            <div class="row g-3 mt-3">
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6 class="text-muted">Total Pesanan</h6>
                        <h3 class="fw-bold text-primary">{{ $totalOrders }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6 class="text-muted">Diproses</h6>
                        <h3 class="fw-bold text-warning">{{ $processingOrders }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6 class="text-muted">Dikirim</h6>
                        <h3 class="fw-bold text-info">{{ $shippingOrders }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6 class="text-muted">Selesai</h6>
                        <h3 class="fw-bold text-success">{{ $completedOrders }}</h3>
                    </div>
                </div>
            </div>

           <!-- Recommended products -->
            <hr>
            <h4 class="fw-bold">✨ Rekomendasi Produk</h4>

            <div class="row g-3">
                @foreach($recommendedProducts as $r)
                <div class="col-md-3">
                    <div class="card product-card p-2">
                        <img src="{{ asset('uploads/products/' . $r->gambar) }}">
                        <h6 class="mt-2">{{ $r->nama_produk }}</h6>
                        <p class="fw-bold text-primary">Rp {{ number_format($r->harga) }}</p>
                    </div>
                </div>
                @endforeach
            </div>


            <!-- Pesanan -->
            <hr class="my-4">
            <h4 id="orders-section" class="fw-bold">📦 Pesanan Saya</h4>

            <div class="card p-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $o)
                        <tr>
                            <td>#{{ $o->id }}</td>
                            <td>{{ $o->created_at->format('d M Y H:i') }}</td>
                            <td>Rp {{ number_format($o->total) }}</td>
                            <td>
                                <span class="badge text-bg-{{ 
                                    $o->status=='pending' ? 'secondary' : 
                                    ($o->status=='diproses' ? 'warning' : 
                                    ($o->status=='dikirim' ? 'info' : 'success')) }}">
                                    {{ ucfirst($o->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>
