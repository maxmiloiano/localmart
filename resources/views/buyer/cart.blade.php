<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang | Buyer</title>
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

        .sidebar a.active {
            background-color: #0056b3;
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .qty-box button {
            width: 32px;
            height: 32px;
            border: 1px solid #ccc;
            background: #fff;
        }

        .qty-box input {
            width: 45px;
            text-align: center;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container-fluid">
<div class="row">

    <!-- SIDEBAR -->
    <div class="col-md-3 col-lg-2 sidebar">
        <h4 class="text-center mb-4">Buyer Menu</h4>

        <a href="{{ route('buyer.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('buyer.products') }}">📦 Produk</a>
        <a href="{{ route('buyer.chat.list') }}">💬 Chat Buyer</a>
        <a href="{{ route('buyer.cart') }}" class="active">🛒 Keranjang</a>
        <a href="{{ route('buyer.dashboard') }}#orders-section">📦 Pesanan Saya</a>

        <form action="{{ route('logout') }}" method="GET">
            <button class="btn btn-danger w-100 mt-3">Logout</button>
        </form>
    </div>

    <!-- CONTENT -->
    <div class="col-md-9 col-lg-10 p-4">
        <h3 class="fw-bold mb-3">🛒 Keranjang Belanja</h3>

        @foreach($cartItems as $sellerId => $items)
        <div class="card mb-3">

            <!-- SELLER -->
            <div class="card-header bg-light fw-bold">
                <input type="checkbox"
                       class="form-check-input me-2 seller-checkbox"
                       data-seller="{{ $sellerId }}">
                ⭐ {{ $items->first()->seller_name }}
            </div>
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    @foreach($items as $item)
                    <tr>
                        <td width="40">
                            <input type="checkbox"
                                   class="form-check-input product-checkbox"
                                   data-seller="{{ $sellerId }}">
                        </td>

                        <td width="90">
                            <img src="{{ asset('uploads/products/' . $item->gambar) }}"
                                 class="product-img">
                        </td>

                        <td><b>{{ $item->nama_produk }}</b></td>

                        <td>Rp {{ number_format($item->harga) }}</td>

                        <td width="170">
                            <!-- UPDATE QTY -->
                            <form action="{{ route('buyer.cart.update', $item->id_cart) }}"
                                  method="POST"
                                  class="qty-form"
                                  data-qty="{{ $item->qty }}"
                                  data-id="{{ $item->id_cart }}">
                                @csrf

                                <div class="qty-box">
                                    <button type="button"
                                            class="btn-minus"
                                            data-qty="{{ $item->qty }}"
                                            data-id="{{ $item->id_cart }}">
                                        −
                                    </button>

                                    <input type="text" value="{{ $item->qty }}" readonly>

                                    <button type="submit" name="qty" value="{{ $item->qty + 1 }}">
                                        +
                                    </button>
                                </div>
                            </form>

                            <!-- DELETE FORM (HIDDEN) -->
                            <form id="delete-form-{{ $item->id_cart }}"
                                  action="{{ route('buyer.cart.delete', $item->id_cart) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>

                        <td class="text-danger fw-bold">
                            Rp {{ number_format($item->harga * $item->qty) }}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endforeach

        <div class="text-end mt-4">
            <h4 class="fw-bold">Total: Rp {{ number_format($totalHarga) }}</h4>
            <form action="{{ route('buyer.checkout') }}" method="POST">
    @csrf

    @foreach($cartItems as $items)
        @foreach($items as $item)
            <input type="hidden"
                   name="cart_ids[]"
                   value="{{ $item->id_cart }}"
                   class="checkout-item"
                   disabled>
        @endforeach
    @endforeach

    <button class="btn btn-success">✔ Checkout</button>
</form>

        </div>
    </div>
</div>
</div>

<!-- JS -->
<script>
// Checkbox seller
document.querySelectorAll('.seller-checkbox').forEach(box => {
    box.addEventListener('change', function () {
        document.querySelectorAll(
            `.product-checkbox[data-seller="${this.dataset.seller}"]`
        ).forEach(cb => cb.checked = this.checked);
    });
});

// Qty minus confirm delete
document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.addEventListener('click', function () {
        const qty = parseInt(this.dataset.qty);
        const id  = this.dataset.id;

        if (qty === 1) {
            if (confirm('Apakah anda yakin ingin menghapus produk ini dari keranjang?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        } else {
            this.closest('form').submit();
        }
    });
});
</script>
<script>
document.querySelector('form[action*="checkout"]').addEventListener('submit', function () {
    document.querySelectorAll('.checkout-item').forEach(input => {
        input.disabled = true;
    });

    document.querySelectorAll('.product-checkbox:checked').forEach(cb => {
        const row = cb.closest('tr');
        const cartId = row.querySelector('.btn-minus').dataset.id;

        document.querySelectorAll('.checkout-item').forEach(input => {
            if (input.value === cartId) {
                input.disabled = false;
            }
        });
    });
});
</script>


</body>
</html>
