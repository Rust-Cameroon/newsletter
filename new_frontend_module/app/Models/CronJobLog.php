<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronJobLog extends Model
{
    use HasFactory;

    public function getDurationAttribute()
    {
        return Carbon::parse($this->started_at)->diffInSeconds($this->ended_at);
    }

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];
}
