<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'created_by',
        'tanggal_awal',
        'tanggal_akhir',
        'total_pendapatan',
        'total_pengeluaran',
        'laba'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
