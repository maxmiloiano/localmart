<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $timestamps = false;

    protected $fillable = [
        'id_buyer',
        'tanggal_order',
        'total_harga',
        'status_order'
    ];

    // Relasi ke buyer (user)
    public function buyer()
    {
        return $this->belongsTo(User::class, 'id_buyer', 'id_user');
    }

    // Relasi ke detail order
    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
