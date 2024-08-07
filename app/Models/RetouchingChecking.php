<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetouchingChecking extends Model
{
    protected $fillable = ['ilc', 'uji_lab', 'penampakan', 'tekstur', 'bau', 'hasil', 'es', 'suhu', 'hasil'];
    use HasFactory;
}