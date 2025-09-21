<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'Evenement';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Id',
        'Nom',
        'Description',
        'TypeId'
    ];

    public function Type() {
        return $this->belongsTo(Type::class, 'TypeId');
    }

    /**
     * Acesseur qui renvoie et ajoute en MAJ (la renommer comme le champ que l'on souhaite manipuler)
     *
     * @return Attribute
     */
    protected function TestAcessseur(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value,
            get: fn ($value) => strtoupper($value)           
        );
    }
}
