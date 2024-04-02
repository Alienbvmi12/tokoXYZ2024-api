<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'no_transaksi',
        'tgl_transaksi',
        'id_barang',
        'harga',
        'qty'
    ];

    public function barang(){
        return $this->hasOne(Barang::class, 'id', 'id_barang');
    }
}
