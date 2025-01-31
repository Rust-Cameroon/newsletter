<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OthersBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'name',
        'code',
        'processing_time',
        'processing_type',
        'charge',
        'charge_type',
        'minimum_transfer',
        'maximum_transfer',
        'daily_limit_maximum_amount',
        'daily_limit_maximum_count',
        'monthly_limit_maximum_amount',
        'monthly_limit_maximum_count',
        'field_options',
        'details',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
