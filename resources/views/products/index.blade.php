<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        img {
            max-width: 100px;
            border-radius: 5px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-warning {
            background-color: orange;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>

    <h1>Daftar Produk</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    <br><br>

    <table>
        <thead>
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
                        <div class="action-buttons">
                            <a href="{{ route('products.edit', $product->id_product) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product->id_product) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
