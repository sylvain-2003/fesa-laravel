<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $fillable = ['user_id', 'categorie_id', 'titre', 'description', 'budget', 'statut'];
    public function user() { return $this->belongsTo(User::class); }
    public function categorie() { return $this->belongsTo(Categorie::class); }
    public function propositions() { return $this->hasMany(Proposition::class)->latest(); }
}
