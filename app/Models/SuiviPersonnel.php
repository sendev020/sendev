<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuiviPersonnel extends Model
{
     use HasFactory;

    protected $fillable = [
        'personnel_id', 'type', 'motif', 'date_debut', 'date_fin'
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
    // Scope pour filtrer par type
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public static function limitesParType()
{
    return [
        'congé' => 30,
        'absence' => 10,
        'retard' => 20,
        'permission' => 15,
        'maladie' => 25,
    ];
}

public static function totalParTypeEtPersonnel($personnelId, $type)
{
    return self::where('personnel_id', $personnelId)
        ->where('type', $type)
        ->sum(\DB::raw("DATEDIFF(COALESCE(date_fin, date_debut), date_debut) + 1"));
}

}
