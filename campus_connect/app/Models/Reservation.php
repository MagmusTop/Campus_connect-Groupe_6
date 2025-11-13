<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 
        'salle_id', 
        'equipement_id',
        'date_debut', 
        'date_fin', 
        'statut', 
        'motif'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function equipement()
    {
        return $this->belongsTo(Equipement::class);
    }

    public function reponse()
    {
        return $this->hasOne(Reponse::class);
    }
}
