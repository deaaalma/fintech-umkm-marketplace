<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function checklists()
    {
        return $this->hasMany(OrderChecklist::class);
    }
}
