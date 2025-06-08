<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'asesi_ternilai_id',
        'penilai_id',
        'detail_penilaian',
        'total_akhir',
        'bulan_penilaian'
    ];

    protected $casts = [
        'detail_penilaian' => 'array',
        'bulan_penilaian' => 'date:Y-m-01'
    ];

    public function asesiTernilai()
    {
        return $this->belongsTo(User::class, 'asesi_ternilai_id');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }
}