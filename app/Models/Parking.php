<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $table = 'parking';

    protected $fillable = [
        'numero_place',
        'est_occupe',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'est_occupe' => 'boolean'
    ];

    /**
     * Obtient l'utilisateur associé à cette place de parking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vérifie si la place est disponible
     */
    public function estDisponible()
    {
        return !$this->est_occupe;
    }

    /**
     * Marque la place comme occupée
     */
    public function marquerOccupee()
    {
        $this->update([
            'est_occupe' => true
        ]);
    }

    /**
     * Marque la place comme libre
     */
    public function marquerLibre()
    {
        $this->update([
            'est_occupe' => false,
            'user_id' => null
        ]);
    }
}
