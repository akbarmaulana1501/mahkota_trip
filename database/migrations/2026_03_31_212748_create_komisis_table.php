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
        Schema::create('komisis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('jamaah_id');
            $table->bigInteger('marketing_id');
            $table->float('nominal_komisi');
            $table->text('keterangan');
            $table->integer('status');
            $table->date('tgl_cair');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komisis');
    }
};
