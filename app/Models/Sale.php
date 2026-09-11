<?php

namespace App\Models;

use App\PaymentMethod;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'total',
        'user_id',
        'payment_method',
        'paid_amount',
        'change',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'change' => 'decimal:2',
            'payment_method' => PaymentMethod::class,
        ];
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
