<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FdrPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'name',
        'type',
        'interest_rate',
        'intervel',
        'locked',
        'minimum_amount',
        'maximum_amount',
        'status',
        'is_compounding',
        'can_cancel',
        'cancel_type',
        'cancel_days',
        'cancel_fee',
        'cancel_fee_type',
        'is_add_fund_fdr',
        'is_deduct_fund_fdr',
        'increment_fee',
        'increment_type',
        'increment_times',
        'min_increment_amount',
        'max_increment_amount',
        'decrement_fee',
        'decrement_type',
        'decrement_times',
        'increment_charge_type',
        'decrement_charge_type',
        'min_decrement_amount',
        'max_decrement_amount',
        'add_maturity_platform_fee',
        'maturity_platform_fee',
        'badge',
        'featured',
    ];

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
