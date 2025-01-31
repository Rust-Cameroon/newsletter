<?php

namespace App\Models;

use App\Enums\FdrStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fdr extends Model
{
    use HasFactory;

    protected $table = 'fdr';

    protected $appends = ['day'];

    protected $fillable = [
        'fdr_id',
        'user_id',
        'fdr_plan_id',
        'amount',
        'status',
        'end_date',
    ];

    protected $casts = [
        'status' => FdrStatus::class,
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(FdrPlan::class, 'fdr_plan_id');
    }

    public function getDayAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FDRTransaction::class);
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', FdrStatus::Running->value);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', FdrStatus::Closed->value);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', FdrStatus::Completed->value);
    }

    public function profit()
    {
        return ($this->amount / 100) * $this->plan->interest_rate;
    }

    public function totalInstallment()
    {
        return (int) ($this->plan->locked / $this->plan->intervel);
    }

    public function givenInstallemnt()
    {
        return $this->transactions->where('paid_amount', '!=', null)->count();
    }
}
