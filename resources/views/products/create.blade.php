<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
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
    <h1>Tambah Produk</h1>

    {{-- Tampilkan pesan sukses jika ada --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Tampilkan pesan error validasi --}}
    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Tambahkan enctype="multipart/form-data" untuk upload file --}}
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" required>
    </div>

    <div>
        <label>Kategori</label>
        <input type="text" name="kategori">
    </div>

    <div>
        <label>Deskripsi</label>
        <textarea name="deskripsi"></textarea>
    </div>

    <div>
        <label>Harga</label>
        <input type="number"  name="harga" required>
    </div>

    <div>
        <label>Stok</label>
        <input type="number" name="stok" required>
    </div>

    <div>
        <label>Upload Gambar</label>
        <input type="file" name="gambar" accept="image/*">
    </div>

    <button type="submit">Simpan</button>
</form>

</body>
</html>
