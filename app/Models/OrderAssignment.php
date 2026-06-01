<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAssignment extends Model
{
    protected $table = 'order_assignments';

    protected $guarded = ['id'];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
