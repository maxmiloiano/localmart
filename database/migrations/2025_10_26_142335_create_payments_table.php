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
    Schema::create('payments', function (Blueprint $table) {
        $table->id('id_payment');
        $table->unsignedBigInteger('id_order');
        $table->enum('metode_pembayaran', ['transfer','cod','ewallet'])->default('transfer');
        $table->enum('status_pembayaran', ['belum_bayar','sudah_bayar','gagal'])->default('belum_bayar');
        $table->dateTime('tanggal_pembayaran')->nullable();
        $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
