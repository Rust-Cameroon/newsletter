<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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
                ->orWhere('locale', 'like', '%'.$search.'%');
        }

        return $query;
    }
}
