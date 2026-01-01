<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserMahasiswa extends Authenticatable
{

    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use HasUuids;

    protected $table = 'users_mahasiswa';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'name',
        'email',
        'password',
        'role_access',
        'privilege_pmb',
        'q1',
        'a1',
        'q2',
        'a2',
        'forgot_password_send_email',
        'created_by',
        'updated_by',
        'isactive',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'a1', // Sembunyikan jawaban keamanan secara default
        'a2', // Sembunyikan jawaban keamanan secara default
    ];

    protected $appends = [
//        'profile_photo_url',
        'user_type'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getUserTypeAttribute(): string
    {
        return 'mahasiswa';
    }

    public function MasterGroup()
    {
        return $this->belongsTo(MasterGroup::class, 'role_access', 'KodeGroupUser');
    }

    public function MasterGroupPMB()
    {
        return $this->belongsTo(PrivilegePMB::class, 'privilege_pmb', 'KodeGroupUser');
    }
}
