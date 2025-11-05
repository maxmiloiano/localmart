<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Marketplace</title>

    {{-- ✅ Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px 35px;
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            text-align: center;
            margin-bottom: 25px;
            color: #1e293b;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            background-color: #4f46e5;
            border: none;
            color: white;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }
        .error-msg {
            background-color: #fee2e2;
            color: #b91c1c;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
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

    <div class="login-card">
        <h3 class="login-title">🔐 Login ke Sistem</h3>

        {{-- ✅ Pesan Error --}}
        @if ($errors->any())
            <div class="error-msg">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ✅ Form Login --}}
        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email"
                       name="email"
                       id="email"
                       class="form-control"
                       placeholder="Masukkan email anda"
                       required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="form-control"
                       placeholder="Masukkan password"
                       required>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
            <div class="footer-text">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar di sini</a>
            </div>

        <div class="footer-text">
            © {{ date('Y') }} Sistem Marketplace | Laravel
        </div>
    </div>

    {{-- ✅ Bootstrap JS (opsional, untuk animasi tombol) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
