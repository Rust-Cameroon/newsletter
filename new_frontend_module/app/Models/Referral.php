<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeType($query, $type)
    {
        return $query->where('type', $type)->get();
    }

    public function target()
    {
        return $this->belongsTo(ReferralTarget::class, 'referral_target_id');
    }
}
