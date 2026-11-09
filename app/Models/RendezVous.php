<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';
    protected $fillable = ['demandeur_id', 'fournisseur_id', 'date_heure', 'statut'];
    protected $casts = ['date_heure' => 'datetime'];
    public function demandeur()
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }
    public function fournisseur()
    {
        return $this->belongsTo(User::class, 'fournisseur_id');
    }
}