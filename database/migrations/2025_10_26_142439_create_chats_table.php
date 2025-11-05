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
    Schema::create('chats', function (Blueprint $table) {
        $table->id('id_chat');
        $table->unsignedBigInteger('id_sender');
        $table->unsignedBigInteger('id_receiver');
        $table->text('pesan');
        $table->dateTime('waktu')->useCurrent();
        $table->foreign('id_sender')->references('id_user')->on('users')->onDelete('cascade');
        $table->foreign('id_receiver')->references('id_user')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
