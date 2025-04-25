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
        Schema::create('laporan_jpminimal', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->integer('fasilitator_id', false, true);
            $table->integer('bulan');
            $table->integer('tahun');
            $table->string('status')->default('draft');
            $table->timestamps();
        });

        Schema::create('laporan_jpminimal_detail', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('laporan_jpminimal_id');
            $table->string('jadwal');
            $table->string('mata_pelatihan');
            $table->date('tanggal');
            $table->integer('jumlah_jp');
            $table->tinyInteger('kategori', false, true);
            $table->timestamps();

            $table->foreign('laporan_jpminimal_id')->references('id')->on('laporan_jpminimal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_jpminimal');
    }
};
