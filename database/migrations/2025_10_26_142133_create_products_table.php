<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
    $table->id('id_product');
    $table->unsignedBigInteger('id_seller');
    $table->string('nama_produk');
    $table->text('deskripsi');
    $table->integer('stok');
    $table->decimal('harga', 12, 2);
    $table->string('kategori');
    $table->string('gambar')->nullable();
    $table->timestamps();

    // 🔥 Pastikan referensi ke id_user, bukan id
    $table->foreign('id_seller')->references('id_user')->on('users')->onDelete('cascade');
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
