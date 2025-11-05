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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id('id_review');
        $table->unsignedBigInteger('id_product');
        $table->unsignedBigInteger('id_user');
        $table->integer('rating');
        $table->text('komentar')->nullable();
        $table->dateTime('tanggal_review')->useCurrent();
        $table->foreign('id_product')->references('id_product')->on('products')->onDelete('cascade');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
