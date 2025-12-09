<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Glasses extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active'     => 'boolean',
        'price'         => 'decimal:2',
        'purchase_price'=> 'decimal:2',
    ];

    // ──────────────────────────────────────────────────────
    // Relations
    // ──────────────────────────────────────────────────────
    public function user(): BelongsTo
    { return $this->belongsTo(User::class); }
    public function brand(): BelongsTo      { return $this->belongsTo(Brand::class); }
    public function category(): BelongsTo   { return $this->belongsTo(Category::class); }

    // ──────────────────────────────────────────────────────
    // Slug auto-généré : ray-ban-rb4640-noir
    // ──────────────────────────────────────────────────────
    protected static function booted()
    {
        static::creating(function ($glasses) {
            $glasses->slug = $glasses->generateUniqueSlug();
        });

        static::updating(function ($glasses) {
            $glasses->slug = $glasses->generateUniqueSlug();
        });
    }

    public function generateUniqueSlug(): string
    {
        $base = Str::slug("{$this->brand?->name} {$this->reference} {$this->color}");

        $slug = $base;
        $i = 1;
        while (self::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    // ──────────────────────────────────────────────────────
    // URLs pratiques
    // ──────────────────────────────────────────────────────
    public function frontImageUrl(): string
    {
        return $this->image_front 
            ? asset('storage/' . $this->image_front) 
            : asset('images/no-glasses.png');
    }

    public function gltfUrl(): ?string
    {
        return $this->gltf_model 
            ? asset('storage/gltf/' . $this->gltf_model) 
            : null;
    }
}