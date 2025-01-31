<?php

namespace App\Models;

use App\Enums\BillStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Bill extends Model
{
    use HasFactory;

    protected $appends = ['day'];

    protected $fillable = [
        'bill_service_id',
        'amount',
        'user_id',
        'data',
        'status',
    ];

    protected $casts = [
        'status' => BillStatus::class,
        'data' => 'array',
    ];

    public function getDayAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(BillService::class, 'bill_service_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', BillStatus::Pending->value);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', BillStatus::Completed->value);
    }

    public function scopeReturned($query)
    {
        return $query->where('status', BillStatus::Return->value);
    }
}
