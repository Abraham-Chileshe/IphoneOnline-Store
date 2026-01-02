<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ru',
        'slug',
        'is_active',
    ];

    /**
     * Get the localized name of the city.
     */
    public function getLocalizedNameAttribute(): string
    {
        return app()->getLocale() === 'ru' ? $this->name_ru : $this->name_en;
    }
}
