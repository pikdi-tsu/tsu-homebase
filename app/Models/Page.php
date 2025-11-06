<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'published_at',
        'users_dosen_tendik_id',
    ];

    // INI PENTING UNTUK BUILDER
    // Otomatis ubah JSON dari/ke array saat akses 'content'
    protected $casts = [
        'content' => 'array',
        'published_at' => 'datetime',
    ];

    // Relasi ke Author (User)
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserDosenTendik::class);
    }
}
