<?php

namespace App\Models;

use App\Enums\LoanStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $appends = ['day'];

    protected $fillable = [
        'loan_no',
        'loan_plan_id',
        'user_id',
        'amount',
        'submitted_data',
        'status',
    ];

    protected $casts = [
        'status' => LoanStatus::class,
        'amount' => 'int',
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

    public function getDayAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->hasOne(LoanPlan::class, 'id', 'loan_plan_id');
    }

    public function scopeDue($query)
    {
        return $query->where('status', LoanStatus::Due->value);
    }

    public function scopeRunning($query)
    {
        return $query->where('status', LoanStatus::Running->value);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', LoanStatus::Completed->value);
    }

    public function scopeReviewing($query)
    {
        return $query->where('status', LoanStatus::Reviewing->value);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', LoanStatus::Rejected->value);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(LoanTransaction::class);
    }

    public function givenInstallemnt()
    {
        return $this->transactions->whereNotNull('given_date')->count();
    }

    public function totalPayableAmount(): float|int
    {
        $amount = $this->amount;
        $perInstallment = ($amount / 100) * $this->plan->per_installment;
        $totalInstallment = $this->plan->total_installment;

        return $perInstallment * $totalInstallment;
    }
}
