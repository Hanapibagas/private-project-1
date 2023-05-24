<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;
    protected $fillable =[
        'nama',
        'gambar',
        'satuan',
        'harga',
        'stok',
        'user_id',
    ];
}
