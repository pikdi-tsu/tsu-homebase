<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class BackupUsersDosenTendik extends Model
{
    use HasApiTokens;

    use Notifiable;
    use HasRoles;

    protected $table = 'backup_users_dosen_tendik';

    protected $fillable = [
        'nip',
        'nama',
        'homebase',
        'jenkel',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'nidn',
        'gelar_depan',
        'gelar_belakang',
        'golongan_pangkat',
        'jabatan_fungsional',
        'jabatan_struktural',
        'alamat',
        'no_telp',
        'email_pribadi',
        'email_kampus',
    ];


    protected function namaLengkapDanNip(): Attribute
    {
        return Attribute::make(
        // `get` akan dijalankan setiap kali kita memanggil $dosen->nama_lengkap_dan_nik
            get: fn () => "{$this->nip} - {$this->nama}", // Sesuaikan 'nama_dosen' dan 'nik' dengan nama kolom di tabelmu
        );
    }
}
