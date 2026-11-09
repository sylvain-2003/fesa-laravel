<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'pseudo', 'nom', 'email', 'password', 'photo', 'type_membre',
        'nif', 'type_piece', 'numero_piece',
        'role', 'actif', 'tentatives_echec', 'bloque_jusqua',
    ];

    protected $hidden = ['password', 'remember_token', 'nif', 'numero_piece'];
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'actif' => 'boolean',
            'bloque_jusqua' => 'datetime',
        ];
    }
    public function estAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function abonnementActif(): ?Abonnement
    {
        return $this->abonnements()
            ->where('statut', 'actif')
            ->whereDate('date_fin', '>=', now())
            ->latest('date_fin')
            ->first();
    }
    public function estAbonne(): bool
    {
        return $this->abonnementActif() !== null;
    }
    public function suit(User $membre): bool
    {
        return $this->suivis()->where('users.id', $membre->id)->exists();
    }
    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
    public function propositions()
    {
        return $this->hasMany(Proposition::class);
    }
    public function abonnements()
    {
        return $this->hasMany(Abonnement::class);
    }
    public function alertes()
    {
        return $this->hasMany(Alerte::class);
    }
    public function horaires()
    {
        return $this->hasMany(HoraireService::class);
    }
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
    // Les membres que je suis
    public function suivis()
    {
        return $this->belongsToMany(User::class, 'suivis', 'follower_id', 'suivi_id')->withTimestamps();
    }
    // Les membres qui me suivent
    public function suiveurs()
    {
        return $this->belongsToMany(User::class, 'suivis', 'suivi_id', 'follower_id')->withTimestamps();
    }
}