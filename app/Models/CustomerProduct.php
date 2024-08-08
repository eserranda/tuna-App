<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProduct extends Model
{

    protected $fillable = [
        'ilc',
        'id_customer',
        'id_produk',
        'berat',
        'tanggal',
        'checking',
    ];


    public function customer()
    {
        return $this->belongsTo(Customers::class, 'id_customer');
    }

    public function produk()
    {
        return $this->belongsTo(Products::class, 'id_produk');
    }

    use HasFactory;
}
