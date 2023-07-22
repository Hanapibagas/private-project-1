<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangExpired extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'total',
        'jumlah',
        'keterangan',
    ];
}
