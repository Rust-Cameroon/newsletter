<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function method(): BelongsTo
    {
        return $this->belongsTo(WithdrawMethod::class, 'withdraw_method_id')->withDefault();
    }
}
