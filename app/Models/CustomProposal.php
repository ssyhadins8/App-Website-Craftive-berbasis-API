<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomProposal extends Model {
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'craft_type',
        'material',
        'budget',
        'deadline_days',
        'description',
        'difficulty',
        'estimated_days',
        'material_cost',
        'labor_cost',
        'shop_recommendation',
        'agent_reasoning',
        'status',
        'order_id'
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'material_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'deadline_days' => 'integer',
        'estimated_days' => 'integer'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
