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
    Schema::create('order_details', function (Blueprint $table) {
        $table->id('id_order_detail');
        $table->unsignedBigInteger('id_order');
        $table->unsignedBigInteger('id_product');
        $table->integer('jumlah');
        $table->decimal('subtotal', 12, 2);
        $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
        $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
