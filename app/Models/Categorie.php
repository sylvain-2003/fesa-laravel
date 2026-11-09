<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom'];
    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}