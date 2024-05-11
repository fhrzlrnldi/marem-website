<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->integer('harga');
            $table->string('gambar_produk')->nullable(); // nullable untuk menangani produk tanpa gambar
            $table->integer('status')->default(1); // status barang (1: ready, 2: not ready)
            $table->timestamps();
        });
        //  nama, harga, gambar produk, status
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
};
