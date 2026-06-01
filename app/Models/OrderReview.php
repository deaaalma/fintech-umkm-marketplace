<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    protected $table = 'order_reviews';

    protected $fillable = [
        'order_id',
        'customer_id',
        'umkm_id',
        'rating',
        'is_recommended',
        'comment',
        'images',
        'issue_type_id',
        'is_resolved',
    ];

    protected $casts = [
        'images' => 'json',
        'is_recommended' => 'boolean',
        'is_resolved' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
