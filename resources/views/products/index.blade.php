<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk Seller</title>
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
            padding: 25px;
        }

        .table img {
            max-width: 90px;
            border-radius: 5px;
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

            <a href="{{ route('seller.dashboard') }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('products.index') }}" class="active">
                📦 Daftar Produk
            </a>
             <a href="{{ route('seller.chat') }}">
                💬 Chat Seller
            </a>

            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit" class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 content">
            <h2 class="fw-bold mb-4">Daftar Produk</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
                + Tambah Produk
            </a>

            <!-- TABLE -->
            <div class="card p-3 shadow-sm">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->nama_produk }}</td>
                            <td>{{ $product->kategori }}</td>
                            <td>{{ $product->deskripsi }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>
                                @if($product->gambar)
                                    <img src="{{ asset('uploads/products/' . $product->gambar) }}" alt="{{ $product->nama_produk }}">
                                @else
                                    <em>Tidak ada gambar</em>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product->id_product) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('products.destroy', $product->id_product) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3">Belum ada produk.</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>
</body>
</html>
