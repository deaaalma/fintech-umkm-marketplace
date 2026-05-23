<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditLog extends Model
{
    protected $fillable = ['umkm_id', 'adjusted_by', 'amount', 'type', 'note'];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function adjustedBy()
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }
}
