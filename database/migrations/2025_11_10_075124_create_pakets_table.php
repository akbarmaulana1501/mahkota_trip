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
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('jenis_paket');
            $table->date('tgl_berangkat')->nullable();
            $table->string('hotel_mekkah');
            $table->string('hotel_madinah');
            $table->string('lokasi_mekkah');
            $table->string('lokasi_madinah');
            $table->float('harga_paket', 20, 2);
            $table->integer('kuota');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
