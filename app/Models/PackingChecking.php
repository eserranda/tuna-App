<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingChecking extends Model
{

    protected $fillable = [
        'ilc',
        'uji_lab',
        'penampakan',
        'bau',
        'es',
        'suhu',
        'parasite',
        'label',
    ];

    use HasFactory;
}