<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'penilaian',
        'asesi_id',
        'asesor_id',
        'bobot',
        'is_active'
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relationship to groups table for asesi
    public function asesi()
    {
        return $this->belongsTo(Group::class, 'asesi_id', 'group_id');
    }

    // Relationship to groups table for asesor
    public function asesor()
    {
        return $this->belongsTo(Group::class, 'asesor_id', 'group_id');
    }
}