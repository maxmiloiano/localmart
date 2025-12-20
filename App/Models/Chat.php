<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';
    protected $primaryKey = 'id_chat';
    public $timestamps = true;

    protected $fillable = [
        'id_sender',
        'id_receiver',
        'pesan',
        'waktu'
    ];

    // Relasi ke pengirim
    public function sender()
    {
        return $this->belongsTo(User::class, 'id_sender', 'id_user');
    }

    // Relasi ke penerima
    public function receiver()
    {
        return $this->belongsTo(User::class, 'id_receiver', 'id_user');
    }
}
