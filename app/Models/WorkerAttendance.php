<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerAttendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
