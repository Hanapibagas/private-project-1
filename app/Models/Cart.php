<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'bahanbaku_id', 'jumlah'
    ];

    public function bahanBaku(){
        return $this->belongsTo(BahanBaku::class, 'bahanbaku_id');
    }
}
