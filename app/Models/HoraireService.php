<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoraireService extends Model
{
    protected $fillable = ['user_id', 'jour', 'heure_debut', 'heure_fin'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}