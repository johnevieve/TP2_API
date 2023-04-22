<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Missile extends Model
{
    use HasFactory;

    protected $fillable = [
        'partie_id',
        'coordonnee',
        'resultat'
    ];

}
