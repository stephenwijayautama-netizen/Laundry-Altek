<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'pelanggan_id',
        'user_id',
        'kode_transaksi',
        'tanggal_masuk',
        'tanggal_selesai',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran',
        'tipe_transaksi',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(Detail_Transaksi::class);
    }
}