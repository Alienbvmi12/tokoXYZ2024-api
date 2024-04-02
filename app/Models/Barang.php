<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    public function transaksi(){
        return $this->belongsTo(Transaksi::class, "id_barang", "id");
    }
}
