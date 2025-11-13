<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 
        'poste',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Les réponses validées/rejetées par cet admin
    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'administrateur_id');
    }
}

