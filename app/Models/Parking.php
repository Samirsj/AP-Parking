<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $table = 'parking'; // Nom exact de la table

    protected $fillable = [
        'numero_place',
        'est_occupe',
    ];
}
