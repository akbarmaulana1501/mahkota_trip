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
        Schema::create('distribusi_logistiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyerahan_id')
                ->constrained('penyerahans')
                ->cascadeOnDelete();

            $table->foreignId('logistik_id')
                ->constrained('logistiks')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_logistiks');
    }
};
