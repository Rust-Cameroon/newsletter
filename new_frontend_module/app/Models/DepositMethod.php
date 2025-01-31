<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMethod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'gateway_logo',
    ];

    public function gateway(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Gateway::class, 'gateway_id');
    }

    public function scopeCode($query, $code)
    {
        return $query->where('gateway_code', $code);
    }

    public function getGatewayLogoAttribute()
    {

        if ($this->logo == null) {
            return asset($this->gateway->logo);
        }

        return asset($this->logo);
    }
}
