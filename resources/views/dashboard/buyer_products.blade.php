<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk | Buyer</title>

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
            <h4 class="text-center mb-4">Buyer Menu</h4>

            <a href="{{ route('buyer.dashboard') }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('buyer.products') }}" class="active">
                🛒 Produk
            </a>

            <a href="{{ route('buyer.dashboard') }}#orders-section">
                📦 Pesanan Saya
            </a>

            <form action="{{ route('logout') }}" method="GET"> 
                <button class="btn btn-danger w-100 mt-3">Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">

            <h3 class="fw-bold">🛒 Semua Produk</h3>
            <p>Temukan produk terbaik untuk Anda.</p>

            <!-- Search & Filter -->
            <form method="GET" action="{{ route('buyer.dashboard') }}">
                <div class="row g-2 my-3">
                    <div class="col-md-4">
                        <input name="search" class="form-control" placeholder="Cari produk..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="category" class="form-control">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->nama_category }}"
                                {{ request('category') == $cat->nama_category ? 'selected' : '' }}>
                                {{ $cat->nama_category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="sort" class="form-control">
                            <option value="">Urutkan</option>
                            <option value="price_asc"  {{ request('sort')=='price_asc'?'selected':'' }}>Harga Termurah</option>
                            <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Harga Termahal</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <div class="row g-3">
                @foreach($products as $p)
                <div class="col-md-3">
                    <div class="card product-card p-2">
                        <img src="{{ asset('uploads/products/' . $p->gambar) }}" alt="Produk">
                        <h6 class="mt-2">{{ $p->nama_produk }}</h6>
                        <p class="fw-bold text-primary">Rp {{ number_format($p->harga) }}</p>

                        <a href="{{ route('buyer.product.detail', $p->id_product) }}" class="btn btn-outline-primary w-100">
                            👁️ Lihat Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

</body>
</html>
