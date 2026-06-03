<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Detail_Transaksi;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'satuan',
        'harga',
        'estimasi'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(Detail_Transaksi::class);
    }
}
