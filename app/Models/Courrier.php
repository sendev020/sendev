<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courrier extends Model
{
protected $fillable = [
    'type', 'expediteur', 'destinataire', 'date_reception', 'objet', 'reference', 'fichier',
];

}
