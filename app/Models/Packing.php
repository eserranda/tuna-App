<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{

    protected $fillable = [
        'id_customer',
        'id_produk',
        'tanggal',
        'kode',
        'kode_qr'
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'id_customer', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Products::class, 'id_produk', 'id');
    }

    use HasFactory;
}
