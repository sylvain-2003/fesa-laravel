<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanAbonnement extends Model
{
    protected $fillable = ['nom', 'duree_mois', 'prix'];
    public function abonnements()
    {
        return $this->hasMany(Abonnement::class, 'plan_id');
    }
}