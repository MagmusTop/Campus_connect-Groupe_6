<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $nom
 * @property mixed $type
 */

class Category extends Model
{
    //
    protected $fillable = [
        'nom',
        'type'
    ];

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }
}
