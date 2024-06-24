<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefinedMaterialLots extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_supplier',
        'ilc_cutting',
        'berat',
        'no_ikan',
        'no_loin',
        'grade'
    ];

    public function cutting()
    {
        return $this->belongsTo(Cutting::class, 'id_cutting');
    }
}
