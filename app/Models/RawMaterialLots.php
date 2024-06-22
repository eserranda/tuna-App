<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialLots extends Model
{
    use HasFactory;

    protected $fillable = [
        'ilc',
        'berat',
        'no_ikan',
        'grade',
    ];
}
