<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';  
    protected $primaryKey = 'id_chat';

    protected $fillable = [
        'id_sender',
        'id_receiver',
        'pesan',
        'waktu'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'id_sender');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'id_receiver');
    }
}
