<?php

namespace App\Models;

use App\Models\Glasses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(fn($cat) => $cat->slug = Str::slug($cat->name));
        static::updating(fn($cat) => $cat->slug = Str::slug($cat->name));
    }

    public function glasses()
    {
        return $this->hasMany(Glasses::class);
    }
}