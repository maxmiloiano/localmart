<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'id_order_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_product',
        'jumlah',
        'subtotal'
    ];

    // Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
}
