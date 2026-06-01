<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmWorker extends Model
{
     protected $table = 'umkm_workers';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}
