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
        Schema::create('siskopatus', function (Blueprint $table) {
            $table->id();

            // ======================
            // IDENTITAS DASAR
            // ======================
            $table->integer('id_jamaah');
            $table->string('title')->nullable(); // Tuan / Nyonya
            $table->string('nama_lengkap');
            $table->string('nama_ayah')->nullable();

            // ======================
            // IDENTITAS (KTP / PASPOR)
            // ======================
            $table->string('jenis_identitas')->nullable(); // KTP / PASPOR
            $table->string('no_identitas')->nullable();

            // ======================
            // PASPOR
            // ======================
            $table->string('nama_paspor')->nullable();
            $table->string('no_paspor')->nullable();
            $table->date('tgl_paspor')->nullable();
            $table->string('kota_paspor')->nullable();

            // ======================
            // DATA LAHIR
            // ======================
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // ======================
            // ALAMAT
            // ======================
            $table->text('alamat_lengkap')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();

            // ======================
            // KONTAK
            // ======================
            $table->string('no_telepon')->nullable();
            $table->string('no_hp')->nullable();

            // ======================
            // DATA PRIBADI
            // ======================
            $table->string('kewarganegaraan')->default('Indonesia');
            $table->string('status_pernikahan')->nullable();
            $table->string('pendidikan')->nullable();

            // ======================
            // PEKERJAAN
            // ======================
            $table->string('pekerjaan')->nullable();
            $table->string('pekerjaan_lainnya')->nullable();

            // ======================
            // VISA
            // ======================
            $table->string('provider_visa')->nullable();
            $table->string('no_visa')->nullable();
            $table->date('tgl_berlaku_visa')->nullable();
            $table->date('tgl_akhir_visa')->nullable();

            // ======================
            // ASURANSI
            // ======================
            $table->string('asuransi')->nullable();
            $table->string('no_polis')->nullable();
            $table->date('tgl_input_polis')->nullable();
            $table->date('tgl_awal_polis')->nullable();
            $table->date('tgl_akhir_polis')->nullable();

            // ======================
            // BPJS
            // ======================
            $table->string('no_bpjs')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siskopatus');
    }
};
