<?php

namespace App\Models;

use App\Models\Glasses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(fn($brand) => $brand->slug = Str::slug($brand->name));
        static::updating(fn($brand) => $brand->slug = Str::slug($brand->name));
    }

    public function glasses()
    {
        return $this->hasMany(Glasses::class);
    }
}