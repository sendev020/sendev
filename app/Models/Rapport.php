<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = ['titre', 'filename', 'original_filename', 'type', 'archived_at'];

    protected $dates = ['archived_at'];

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }
}
