<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 
        'matricule', 
        'ecole', 
        'filliere', 
        'niveau'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
