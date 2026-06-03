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
       Schema::create('laporan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('created_by')
            ->constrained('users')
            ->onDelete('cascade');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->decimal('total_pendapatan', 12, 2);
            $table->decimal('total_pengeluaran', 12, 2);
            $table->decimal('laba', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
