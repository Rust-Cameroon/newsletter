<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FDRTransaction extends Model
{
    use HasFactory;

    protected $table = 'fdr_transactions';

    protected $fillable = [
        'fdr_id',
        'given_date',
        'given_amount',
        'paid_amount',
        'charge',
        'final_amount',
    ];

    protected $casts = [
        'given_date' => 'date',
    ];

    public function fdr()
    {
        return $this->hasOne(Fdr::class, 'id', 'fdr_id');
    }
}
