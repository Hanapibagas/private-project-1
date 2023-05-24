<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBakuCustomers extends Model
{
    use HasFactory;
    protected $fillable =[
        'nama',
        'stok',
        'bahanbaku_id',
    ];
}
