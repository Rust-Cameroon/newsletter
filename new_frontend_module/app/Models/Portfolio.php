<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    protected $guarded = [];
}
