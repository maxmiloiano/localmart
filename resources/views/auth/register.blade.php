<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Marketplace</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .register-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px 35px;
            width: 100%;
            max-width: 480px;
        }
        .register-title {
            text-align: center;
            margin-bottom: 25px;
            color: #1e293b;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
        .btn-register {
            border-radius: 10px;
            padding: 12px;
            background-color: #2563eb;
            border: none;
            color: white;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }
        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <h3 class="register-title">📝 Daftar Akun Baru</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="Masukkan email aktif">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Pilih Role</label>
                <select name="role" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="seller">Seller</option>
                    <option value="buyer">Buyer</option>
                </select>
            </div>

            {{-- ✅ Field tambahan: alamat --}}
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor HP</label>
                <input type="text" name="no_hp" class="form-control" required placeholder="Masukkan nomor HP aktif">
            </div>

            <button type="submit" class="btn-register">Daftar Sekarang</button>
        </form>

        <div class="footer-text">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>

</body>
</html>
