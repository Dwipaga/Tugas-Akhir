<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContract extends Model
{
    use HasFactory;

    protected $table = 'employee_contracts';

    protected $fillable = [
        'user_id',
        'contract_data',
        'contract_path',
        'generated_at',
        'status',
    ];

    protected $casts = [
        'contract_data' => 'array', // Cast JSON to array for easy access
        'generated_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Get the user associated with the contract.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}