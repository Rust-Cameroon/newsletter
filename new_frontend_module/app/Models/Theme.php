<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('type', 'site')->where('status', true)->first('name')->name;
    }
}
