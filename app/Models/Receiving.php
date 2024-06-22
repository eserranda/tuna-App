<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receiving extends Model
{
    use HasFactory;

    protected $fillable = [
        'ilc',
        'id_supplier',
        'no_plat',
        'tanggal',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
