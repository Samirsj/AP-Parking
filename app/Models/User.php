<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Vérifie si l'utilisateur est un administrateur
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin == 1;
    }

    /**
     * Obtient la position de l'utilisateur dans la file d'attente
     *
     * @return int|null
     */
    public function positionAttente()
    {
        $attente = $this->hasOne(Attente::class)->first();
        return $attente ? $attente->position : null;
    }

    /**
     * Relation avec la table des places de parking
     */
    public function parking()
    {
        return $this->hasOne(Parking::class);
    }

    /**
     * Relation avec la table des attentes
     */
    public function attente()
    {
        return $this->hasOne(Attente::class);
    }

    /**
     * Relation avec la table historique
     */
    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }

    /**
     * Relation avec la table des listes d'attente
     */
    public function listAttente()
    {
        return $this->hasOne(ListAttente::class, 'user_id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
