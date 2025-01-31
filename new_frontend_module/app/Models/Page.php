<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('title', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%');
        }

        return $query;
    }
}
