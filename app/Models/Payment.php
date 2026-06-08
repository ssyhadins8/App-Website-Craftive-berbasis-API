<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    protected $fillable = ['order_id', 'amount', 'method', 'proof_image', 'status', 'confirmed_at'];
    protected $casts = [
        'amount' => 'decimal:2',
        'confirmed_at' => 'datetime'
    ];

    public function order() { return $this->belongsTo(Order::class); }
}