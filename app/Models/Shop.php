<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Shop extends Model {
    protected $fillable = ['user_id', 'name', 'description', 'logo', 'cover_image', 'address', 'is_verified'];
    protected $casts = ['is_verified' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
    public function products() { return $this->hasMany(Product::class); }
}