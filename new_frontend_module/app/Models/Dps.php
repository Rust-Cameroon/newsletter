<?php

namespace App\Models;

use App\Enums\DpsStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dps extends Model
{
    use HasFactory;

    protected $appends = ['total_dps_amount', 'day'];

    protected $fillable = [
        'dps_id',
        'plan_id',
        'user_id',
        'given_installment',
        'per_installment',
        'status',
        'cancel_date',
        'cancel_fee',
    ];

    protected $casts = [
        'status' => DpsStatus::class,
        'installment_date' => 'date',
    ];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('username', 'like', '%'.$search.'%');
                })->orWhereHas('plan', function($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                });
            });
        }

        return $query;
    }

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y h:i A');
    }

    public function getDayAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M');
    }

    public function getTotalDpsAmountAttribute()
    {
        $amount = $this->per_installment * $this->transactions->count();

        return $amount;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(DpsPlan::class, 'plan_id');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', DpsStatus::Running->value);
    }

    public function scopePayable($query)
    {
        return $query->where('status', DpsStatus::Due->value);
    }

    public function scopeComplete($query)
    {
        return $query->where('status', DpsStatus::Mature->value);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', DpsStatus::Closed->value);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(DpsTransaction::class);
    }
}
