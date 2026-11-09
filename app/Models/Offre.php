<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $fillable = ['user_id', 'categorie_id', 'titre', 'description', 'prix', 'image','video', 'type', 'prix_promo', '
 date_fin'];
    protected $casts = ['date_fin' => 'date'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class)->latest();
    }
}