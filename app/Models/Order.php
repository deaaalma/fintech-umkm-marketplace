<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'booking_date' => 'date',
        'photos' => 'json',
        'work_result_photos' => 'json',
        'is_work_accepted' => 'boolean',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderAssignment()
    {
        return $this->hasOne(OrderAssignment::class, 'order_id');
    }

    public function review()
    {
        return $this->hasOne(OrderReview::class);
    }
}
