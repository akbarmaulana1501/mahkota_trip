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
        Schema::create('jamaahs', function (Blueprint $table) {
            $table->id();

            // Step 1 - Data Diri
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('nama_ayah');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('email')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('pendidikan')->nullable();

            $table->string('kontak_darurat_nama')->nullable();
            $table->string('kontak_darurat_hp', 20)->nullable();

            $table->string('nominal')->nullable();
            $table->string('paket')->nullable();
            $table->string('harga_paket')->nullable();
            $table->unsignedBigInteger('paket_id');

            // Step 2 - Dokumen
            $table->string('status_passport')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('foto_paspor')->nullable();
            $table->string('no_pasport')->nullable();
            $table->date('tgl_terbit')->nullable();
            $table->date('tgl_exp')->nullable();
            $table->text('daerah_terbit')->nullable();
            $table->string('foto_akte')->nullable();

            // Step 3 - Kesehatan
            $table->string('status_vaksin_meningitis')->nullable();
            $table->string('foto_vaksin')->nullable();

            // Step 4 - Pembayaran
            $table->string('bukti_bayar_dp')->nullable();
            $table->integer('status_validasi')->default(0);
            $table->integer('status_visa')->default(0);
            $table->integer('status_asuransi')->default(0);
            $table->integer('status_logistik')->default(0);
            $table->integer('status_keberangkatan')->default(0);

            $table->date('tgl_keberangkatan')->nullable();
            $table->string('id_rombongan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamaahs');
    }
};
