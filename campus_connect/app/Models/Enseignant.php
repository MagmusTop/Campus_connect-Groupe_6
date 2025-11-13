<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

    //
class Enseignant extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 
        'matiere'
    ];

    protected $casts = [
        'matiere' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected function matiere(): Attribute
    {
        return Attribute::make(
           get: function ($value) {
            if (empty($value)) {
                return null;
            }
            return is_string($value) ? json_decode($value, true) : $value;
        },
        set: function ($value) {
            if (empty($value)) {
                return null;
            }
            return is_array($value) ? json_encode($value) : $value;
        },
        );
    }
}
