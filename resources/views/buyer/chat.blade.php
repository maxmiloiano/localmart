<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chat Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">

    <h4 class="mb-3">💬 Chat dengan {{ $seller->name }}</h4>

    <div class="card p-3 mb-3" style="height:300px; overflow-y:auto;">
        @forelse ($chats as $chat)
            <div class="mb-2">
                <b>{{ $chat->sender->name }}</b>
                <p class="mb-0">{{ $chat->pesan }}</p>
                <small class="text-muted">{{ $chat->waktu }}</small>
            </div>
        @empty
            <p class="text-center text-muted">Belum ada pesan</p>
        @endforelse
    </div>

    <form action="{{ route('buyer.chat.send') }}" method="POST">
        @csrf
        <input type="hidden" name="id_receiver" value="{{ $seller->id_user }}">


        <div class="input-group">
            <input type="text" name="pesan" class="form-control" placeholder="Tulis pesan..." required>
            <button class="btn btn-primary">Kirim</button>
        </div>
    </form>

</div>
</body>
</html>
