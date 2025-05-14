<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_vacancy_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'tanggal_lahir',
        'cv_file',
        'portfolio_file',
        'linkedin',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    // Relationships
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getCvUrlAttribute()
    {
        return Storage::disk('public')->url($this->cv_file);
    }

    public function getPortfolioUrlAttribute()
    {
        return $this->portfolio_file ? Storage::disk('public')->url($this->portfolio_file) : null;
    }

    // Status helpers
    public function getStatusBadgeClassAttribute()
    {
        return [
            'pending' => 'badge-warning',
            'reviewed' => 'badge-info',
            'accepted' => 'badge-success',
            'rejected' => 'badge-danger'
        ][$this->status] ?? 'badge-secondary';
    }

    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'Menunggu Review',
            'reviewed' => 'Sudah Direview',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak'
        ][$this->status] ?? $this->status;
    }
}