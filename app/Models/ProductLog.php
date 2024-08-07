<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLog extends Model
{
    protected $fillable = [
        'ilc',
        'id_produk',
        'no_ikan',
        'berat',
        'customer_group',
    ];

    public function produk()
    {
        return $this->belongsTo(Products::class, 'id_produk', 'id');
    }

    use HasFactory;
}
