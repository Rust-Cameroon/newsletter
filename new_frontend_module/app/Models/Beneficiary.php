<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Beneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'account_number',
        'account_name',
        'branch_name',
        'nick_name',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(OthersBank::class, 'bank_id');
    }
}
