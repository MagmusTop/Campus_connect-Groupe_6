<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = [
        'titre', 
        'type',
        'contenu', 
        'user_id', 
        'Categorie_id'
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }
}
