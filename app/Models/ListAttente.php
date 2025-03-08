<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAttente extends Model
{
    use HasFactory;

    protected $table = 'list_attente'; // Nom de la table

    protected $fillable = [
        'user_id',
        'position',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
