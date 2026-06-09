<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAdditionalFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'amount',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
