<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WireTransfar extends Model
{
    use HasFactory;

    protected $fillable = [
        'minimum_transfer',
        'maximum_transfer',
        'charge',
        'charge_type',
        'daily_limit_maximum_amount',
        'daily_limit_maximum_count',
        'monthly_limit_maximum_amount',
        'monthly_limit_maximum_count',
        'instructions',
        'field_options',
    ];
}
