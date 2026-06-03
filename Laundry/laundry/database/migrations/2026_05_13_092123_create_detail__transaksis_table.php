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
        Schema::create('detail_transaksi', function (Blueprint $table) {
    $table->id();

    $table->foreignId('transaksi_id')
        ->constrained('transaksi')
        ->onDelete('cascade');

    $table->foreignId('layanan_id')
        ->constrained('layanan')
        ->onDelete('cascade');

    $table->integer('qty');

    $table->decimal('berat', 8, 2)->nullable();

    $table->decimal('harga_satuan', 12, 2);

    $table->decimal('subtotal', 12, 2);

    $table->string('status_item')->default('proses');

    $table->text('catatan_item')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
