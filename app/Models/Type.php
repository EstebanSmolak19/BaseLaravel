<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'Type';

    protected $fillable = [
        'Id',
        'Nom'
    ];

    public function Events() {
        return $this->hasMany(Event::class, 'TypeId');
    }
}
