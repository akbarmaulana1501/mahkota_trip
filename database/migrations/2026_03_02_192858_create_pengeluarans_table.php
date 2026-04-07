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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('kuantiti');
            $table->string('satuan');
            $table->string('harga_satuan');
            $table->string('total_harga');
            $table->string('created_by');
            $table->string('verified_by')->nullable();
            $table->string('validation_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('validation_at')->nullable();
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
