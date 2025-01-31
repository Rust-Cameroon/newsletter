<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function logs()
    {
        return $this->hasMany(CronJobLog::class, 'cron_job_id', 'id');
    }

    protected $casts = [
        'next_run_at' => 'datetime',
        'last_run_at' => 'datetime',
    ];
}
