<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pekerjaan',
        'jenis_pekerjaan',
        'deskripsi',
        'divisi',
        'min_pengalaman',
        'ditutup_pada',
        'is_active',
        'deskripsi_pekerjaan',
        'contact_person'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ditutup_pada' => 'date',
        'min_pengalaman' => 'integer'
    ];

    // Scope for active jobs
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('ditutup_pada', '>=', now());
    }

    // Scope for expired jobs
    public function scopeExpired($query)
    {
        return $query->where('ditutup_pada', '<', now());
    }

    // Check if job is expired
    public function isExpired()
    {
        return $this->ditutup_pada < now();
    }

    // Relationship with applications
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}