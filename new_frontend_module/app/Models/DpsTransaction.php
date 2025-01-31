<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DpsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'dps_id',
        'installment_date',
        'given_date',
        'paid_amount',
        'deferment',
    ];

    protected $casts = [
        'given_date' => 'date',
    ];

    public function dps(): BelongsTo
    {
        return $this->belongsTo(Dps::class);
    }

    public function getInstallmentDateAttribute()
    {
        return Carbon::parse($this->attributes['installment_date'])->format('d M Y');
    }

    public function scopeNullGivenDateFirstInstallment($query)
    {
        return $query->where('given_date', null)->orderBy('installment_date', 'asc');
    }
}
