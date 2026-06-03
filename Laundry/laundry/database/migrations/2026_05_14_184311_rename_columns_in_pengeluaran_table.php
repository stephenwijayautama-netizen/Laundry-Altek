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
        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->renameColumn('tanggal_pengeluaran', 'tanggal');
            $table->renameColumn('deskripsi', 'keterangan');
            $table->renameColumn('harga', 'jumlah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->renameColumn('tanggal', 'tanggal_pengeluaran');
            $table->renameColumn('keterangan', 'deskripsi');
            $table->renameColumn('jumlah', 'harga');
        });
    }
};
