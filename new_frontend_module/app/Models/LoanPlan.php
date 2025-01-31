<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'name',
        'minimum_amount',
        'maximum_amount',
        'interest_rate',
        'per_installment',
        'installment_intervel',
        'total_installment',
        'admin_profit',
        'instructions',
        'delay_days',
        'charge',
        'charge_type',
        'loan_fee',
        'field_options',
        'status',
        'badge',
        'featured',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getTotalAmountAttribute()
    {
        return $this->per_installment * $this->total_installment;
    }

    public function getBankProfitAttribute()
    {
        return ($this->total_amount * $this->interest_rate / 100) + $this->total_amount;
    }
}
