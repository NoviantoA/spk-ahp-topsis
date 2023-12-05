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
            $table->unsignedBigInteger('alternatif_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->double('nilai');
            $table->timestamps();
            $table->foreign('alternatif_id')->references('alternatif_id')->on('alternatif')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onUpdate('cascade')->onDelete('cascade');
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
