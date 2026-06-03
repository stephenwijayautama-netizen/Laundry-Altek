<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Transaksi;
use App\Models\Layanan;



class Detail_Transaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'layanan_id',
        'qty',
        'berat',
        'harga_satuan',
        'subtotal',
        'status_item',
        'catatan_item'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
