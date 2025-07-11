<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'email',
        'firstname',
        'lastname',
        'phone',
        'photo',
        'password',
        'dokumen',
        'token',
        'created',
        'oss_id',
        'status',
        'username',
        'id_karyawan',
        'tanggal_lahir',
        'tanggal_masuk',
        'tanggal_akhir_kontrak',
        'npwp',
        'jenis_kontrak',
        'dokumen_kontrak',
        'nik',
        'tempat_lahir',
        'alamat',
        'divisi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'token',
        'g-recaptcha-response',
    ];

    /**
     * Get the group that owns the user.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }
}