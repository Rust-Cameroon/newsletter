<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'installment_date',
        'given_date',
        'deferment',
        'paid_amount',
        'charge',
        'final_amount',
    ];

    protected $casts = [
        'installment_date' => 'date',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
