<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Transaksi;


class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'telepon',
        'alamat',
        'status'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}