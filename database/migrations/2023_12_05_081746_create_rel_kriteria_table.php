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
        Schema::create('rel_kriteria', function (Blueprint $table) {
            $table->id('rel_kriteria_id');
            $table->year('tahun');
            $table->string('ID1');
            $table->string('ID2');
            $table->double('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rel_kriteria');
    }
};