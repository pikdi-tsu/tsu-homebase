<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // <-- Ambil dari kolom 'name'
            ->saveSlugsTo('slug')      // <-- Simpan ke kolom 'slug'
            ->doNotGenerateSlugsOnUpdate(); // (Opsional: Biar slug tidak berubah saat di-edit)
    }
}
