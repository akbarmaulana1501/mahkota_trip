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
        Schema::create('tiket_berangkats', function (Blueprint $table) {
            $table->id();
            $table->string('id_jamaah');
            $table->string('maskapai');
            $table->string('bandara');
            $table->integer('jenis');
            $table->date('tgl_berangkat');
            $table->time('waktu_berangkat');
            $table->time('waktu_sampai');
            $table->string('kode');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_berangkats');
    }
};
