<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unique_id',
        'card_id',
        'brand',
        'type',
        'pan',
        'card_no',
        'expiry_month',
        'expiry_year',
        'status',
    ];

    /**
     * Get the user that owns the VirtualCard
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
