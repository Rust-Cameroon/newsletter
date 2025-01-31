<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'routing_number',
        'swift_code',
        'phone',
        'mobile',
        'email',
        'fax',
        'address',
        'map_location',
        'status',
    ];

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('M d Y h:i');
    }

    public function scopeOrder($query, string $order)
    {
        if ($order !== null) {
            return $query->orderBy('id', $order);
        }

        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status && $status != 'all') {
            if ($status == 'active') {
                $status = 1;
            } else {
                $status = 0;
            }

            return $query->where('status', $status);
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%')
                ->orWhere('mobile', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
        }

        return $query;
    }

    public function staffs()
    {
        return $this->hasMany(BranchStaff::class, 'branch_id');
    }
}
