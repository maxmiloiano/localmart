<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LocalMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Poppins', sans-serif;
        }
        .sidebar {
            height: 100vh;
            background: #1e40af;
            color: white;
            padding: 20px;
        }
        .sidebar h3 {
            color: #fff;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: #e0e7ff;
            text-decoration: none;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }
        .sidebar a:hover {
            background: #2563eb;
            color: white;
        }
        .main {
            padding: 30px;
        }
        .table th {
            background-color: #1d4ed8;
            color: white;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .btn-danger {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>🛒 LocalMart Admin</h3>
            <a href="#users">👤 Data Pengguna</a>
            <a href="#products">📦 Data Produk</a>
            <a href="#orders">💳 Data Order</a>
            <form action="{{ route('logout') }}" method="GET" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-light w-100">Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main container-fluid">
            <h2 class="mb-4">Dashboard Admin</h2>

            {{-- =======================
                 DATA PENGGUNA
            ======================= --}}
            <div id="users" class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>👤 Data Pengguna</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id_user }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_hp ?? '-' }}</td>
                                <td>{{ $user->alamat ?? '-' }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $user->role === 'admin' ? 'bg-danger' : ($user->role === 'seller' ? 'bg-success' : 'bg-secondary') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.deleteUser', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- =======================
                 DATA PRODUK
            ======================= --}}
            <div id="products" class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5>📦 Data Produk</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Penjual</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id_product }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->kategori ?? '-' }}</td>
                                <td>{{ Str::limit($product->deskripsi, 40) }}</td>
                                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>{{ $product->stok }}</td>
                                <td>{{ $product->seller->name ?? '-' }}</td>
                                <td>
                                    @if ($product->gambar)
                                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="Gambar Produk" width="60">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- =======================
                 DATA ORDER
            ======================= --}}
            <div id="orders" class="card">
                <div class="card-header bg-warning text-dark">
                    <h5>💳 Data Order</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID Order</th>
                                <th>Pembeli</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Detail Produk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id_order }}</td>
                                <td>{{ $order->buyer->name ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $order->tanggal_order }}</td>
                                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $order->status_order === 'selesai' ? 'bg-success' : 
                                           ($order->status_order === 'dikirim' ? 'bg-info' : 
                                           ($order->status_order === 'dibatalkan' ? 'bg-danger' : 'bg-secondary')) }}">
                                        {{ ucfirst($order->status_order) }}
                                    </span>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($order->details as $detail)
                                            <li>
                                                {{ $detail->product->nama_produk ?? '-' }} 
                                                ({{ $detail->jumlah }}x)
                                            </li>
                                        @endforeach
                                    </ul>
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
