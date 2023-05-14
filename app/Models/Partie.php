<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe pour le model des parties,
 */
class Partie extends Model
{
    use HasFactory;

    protected $fillable = [
        'adversaire',
        'user_id'
    ];
}
