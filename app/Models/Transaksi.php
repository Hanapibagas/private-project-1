<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_pemesanan',
        'status',
        'jumlah_bayar',
        'bukti_bayar',
        'keterangan',
        'total',
    ];

    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksi::class,'transaksi_id');
    }
}
