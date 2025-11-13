<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    protected $fillable = [
        'reservation_id', 
        'administrateur_id', 
        'reponse', 
        'motif'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function administrateur()
    {
        return $this->belongsTo(User::class, 'administrateur_id');
    }
}
