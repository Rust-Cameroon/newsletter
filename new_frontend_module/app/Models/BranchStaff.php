<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document',
        'branch_id',
        'address',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeOrder($query, string $order)
    {
        if ($order !== null) {
            return $query->orderBy('id', $order);
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })->orWhereHas('branch', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })->orWhere('address', 'like', '%'.$search.'%');
            });
        }

        return $query;
    }

    public function scopeBranchId($query, $branch)
    {
        if ($branch && $branch != 0) {
            return $query->where('branch_id', $branch);
        }

        return $query;
    }
}
