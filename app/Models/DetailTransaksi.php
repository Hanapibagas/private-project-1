<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'bahanbaku_id',
        'jumlah',
    ];

    public function transaksi()
    {
        return $this->belongsto(Transaksi::class, 'transaksi_id');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahanbaku_id');
    }
}
