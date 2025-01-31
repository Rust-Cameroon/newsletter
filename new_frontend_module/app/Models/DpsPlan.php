<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DpsPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'interval',
        'total_installment',
        'per_installment',
        'interest_rate',
        'total_deposit',
        'user_profit',
        'total_mature_amount',
        'delay_days',
        'charge',
        'charge_type',
        'status',
        'can_cancel',
        'cancel_type',
        'cancel_days',
        'cancel_fee',
        'cancel_fee_type',
        'badge',
        'featured',
        'is_upgrade',
        'is_downgrade',
        'increment_type',
        'increment_times',
        'decrement_type',
        'decrement_times',
        'min_increment_amount',
        'max_increment_amount',
        'increment_charge_type',
        'decrement_charge_type',
        'min_decrement_amount',
        'max_decrement_amount',
        'add_maturity_platform_fee',
        'maturity_platform_fee',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
