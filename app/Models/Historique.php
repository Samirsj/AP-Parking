<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'parking_id',
        'action',
        'date_action'
    ];

    /**
     * Les attributs qui doivent être convertis en dates.
     *
     * @var array<string, string>
     */
    protected $dates = [
        'date_action',
        'created_at',
        'updated_at'
    ];

    /**
     * Obtient l'utilisateur associé à cet historique.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtient la place de parking associée à cet historique.
     */
    public function parking()
    {
        return $this->belongsTo(Parking::class);
    }
} 