<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        form div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back {
            display: inline-block;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
        }

        img {
            max-width: 120px;
            margin-top: 8px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h1>Edit Produk</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required>
        </div>

        <div>
            <label>Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $product->kategori) }}" required>
        </div>

        <div>
            <label>Deskripsi</label>
            <textarea name="deskripsi">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>

        <div>
            <label>Harga</label>
            <input type="number"  name="harga" value="{{ old('harga', $product->harga) }}" required>
        </div>

        <div>
            <label>Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" required>
        </div>

        <div>
            <label>Gambar</label>
            @if($product->gambar)
                <br>
                <img src="{{ asset('uploads/products/' . $product->gambar) }}" alt="{{ $product->nama_produk }}">
                <br>
            @endif
            <input type="file" name="gambar">
            <small>Biarkan kosong jika tidak ingin mengganti gambar.</small>
        </div>

        <button type="submit">💾 Simpan Perubahan</button>
    </form>

    <a href="{{ route('products.index') }}" class="back">← Kembali ke Daftar Produk</a>

</body>
</html>
