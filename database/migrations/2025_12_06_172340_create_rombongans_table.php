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
        Schema::create('rombongans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rombongan');
            $table->string('nama_rombongan');
            $table->string('id_paket');
            $table->string('id_pembimbing');
            $table->integer('status_asuransi')->default(0);
            $table->string('id_pembimbing2')->nullable();
            $table->string('id_pembimbing3')->nullable();
            $table->string('id_pembimbing4')->nullable();
            $table->string('id_pembimbing5')->nullable();
            $table->string('foto_asuransi')->nullable();
            $table->date('tgl_keberangkatan');
            $table->date('tanggal_kembali');
            $table->integer('jumlah_jamaah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombongans');
    }
};
