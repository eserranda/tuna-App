<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuttingChecking extends Model
{

    protected $fillable = [
        'ilc',
        'whole',
        'uji_lab',
        'tekstur',
        'bau',
        'es',
        'suhu',
        'hasil'
    ];

    use HasFactory;
}
