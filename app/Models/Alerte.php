<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    protected $fillable = ['user_id', 'emetteur_id', 'message', 'lu'];
    protected $casts = ['lu' => 'boolean'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function emetteur()
    {
        return $this->belongsTo(User::class, 'emetteur_id');
    }
}