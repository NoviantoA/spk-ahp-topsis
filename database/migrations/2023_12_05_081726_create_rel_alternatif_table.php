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
        Schema::create('rel_alternatif', function (Blueprint $table) {
            $table->id('rel_alternatif_id');
            $table->year('tahun');
            $table->string('kode_alternatif');
            $table->string('kode_kriteria');
            $table->double('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_alternatif');
    }
};