<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $fillable = [
        'nom',
        'quantite', 
        'description', 
        'Categorie_id'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }
}
