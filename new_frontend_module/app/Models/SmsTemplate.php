<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getMessageBodyAttribute($value)
    {
        return strip_tags($value);
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
            return $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%')
                ->orWhere('for', 'like', '%'.$search.'%');
        }

        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            if ($status === 'active') {
                $_status = 1;
            } else {
                $_status = 0;
            }

            return $query->where('status', $_status);
        }

        return $query;
    }
}
