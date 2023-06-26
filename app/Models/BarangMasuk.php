<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'total',
        'bahanbaku_id',
        'transaksi_id',
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(bahanBaku::class, 'bahanbaku_id');
    }
}
