<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
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

        .preview-img {
            max-width: 160px;
            border-radius: 8px;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR SELLER -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4 class="text-center mb-4">Dashboard Seller</h4>

            <a href="{{ route('seller.dashboard') }}">
                🏠 Dashboard
            </a>

            <a href="{{ route('products.index') }}">
                📦 Daftar Produk
            </a>

            <a class="active">
                ✏️ Edit Produk
            </a>

            <form action="{{ route('logout') }}" method="GET">
                @csrf
                <button type="submit" class="logout-btn">🚪 Logout</button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-9 col-lg-10 content">

            <h2 class="fw-bold mb-4">Edit Produk</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        • {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <div class="card p-4">
                <form action="{{ route('products.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control"
                               value="{{ old('nama_produk', $product->nama_produk) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control"
                               value="{{ old('kategori', $product->kategori) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control"
                               value="{{ old('harga', $product->harga) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control"
                               value="{{ old('stok', $product->stok) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Produk Saat Ini</label><br>

                        @if($product->gambar)
                            <img src="{{ asset('uploads/products/' . $product->gambar) }}" 
                                 alt="{{ $product->nama_produk }}" class="preview-img">
                        @else
                            <p class="text-muted">Tidak ada gambar tersedia</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Gambar Baru</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>

                </form>
            </div>

        </div>

    </div>
</div>
</body>
</html>
