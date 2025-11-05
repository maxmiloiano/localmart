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
    Schema::create('orders', function (Blueprint $table) {
        $table->id('id_order');
        $table->unsignedBigInteger('id_buyer');
        $table->dateTime('tanggal_order')->useCurrent();
        $table->decimal('total_harga', 12, 2);
        $table->enum('status_order', ['pending','diproses','dikirim','selesai','dibatalkan'])->default('pending');
        $table->foreign('id_buyer')->references('id_user')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
