<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'poste',
        'service',
        'anniversaire',
        'adresse' ,// ajouté
        'photo',
        ];

    public function suivis()
{
    return $this->hasMany(SuiviPersonnel::class);
}
}
