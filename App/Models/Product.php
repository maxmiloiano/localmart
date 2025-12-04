<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_product';
    public $timestamps = true;

    protected $fillable = [
        'id_seller',
        'nama_produk',
        'kategori',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'id_category',
    ];

     public function seller()
    {
        return $this->belongsTo(User::class, 'id_seller', 'id_user');
    }
}
