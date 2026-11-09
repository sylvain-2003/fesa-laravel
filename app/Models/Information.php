<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'informations';
    protected $fillable = ['admin_id', 'contenu'];
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}