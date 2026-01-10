<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'name',
        'url',
    ];

    public function accessLogs(): HasMany
    {
        return $this->hasMany(ModuleAccessLog::class);
    }
}
