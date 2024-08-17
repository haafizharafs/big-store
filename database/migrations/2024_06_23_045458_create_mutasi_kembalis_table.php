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
        Schema::create('mutasi_kembalis', function (Blueprint $table) {
            $table->id();
            $table->string('sumber');
            $table->integer('jumlah');
            $table->foreignId('gudang_id')->references('id')->on('gudangs')->onDelete('cascade');
            $table->foreignId('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_kembalis');
    }
};
