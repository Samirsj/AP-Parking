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
        'notes',
        'user_id'
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
        return is_null($this->user_id);
    }

    /**
     * Marque la place comme occupée
     */
    public function marquerOccupee($userId)
    {
        $this->update([
            'user_id' => $userId
        ]);
    }

    /**
     * Marque la place comme libre
     */
    public function marquerLibre()
    {
        $this->update([
            'user_id' => null
        ]);
    }
}
