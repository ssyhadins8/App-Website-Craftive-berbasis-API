<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
    protected $fillable = ['shop_id', 'category_id', 'name', 'description', 'price', 'stock', 'weight', 'images', 'tags', 'style', 'target_demographic', 'is_active', 'rating_avg'];
    protected $casts = [
        'images' => 'array',
        'tags' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'rating_avg' => 'decimal:2'
    ];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            $img = $this->images[0];
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                return $img;
            }
            return asset(ltrim($img, '/'));
        }
        return null;
    }

    public function shop() { return $this->belongsTo(Shop::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(Review::class); }
}