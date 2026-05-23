<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $guarded = ['id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(OrderReview::class);
    }

    public function detail()
    {
        return $this->hasOne(UmkmDetail::class);
    }

    public function creditLogs()
    {
        return $this->hasMany(CreditLog::class)->latest();
    }

    /**
     * Remaining credit = total topped-up - already used
     */
    public function getCreditRemainingAttribute(): int
    {
        return max(0, $this->transaction_credit - $this->credit_used);
    }
}
