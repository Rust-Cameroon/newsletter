<?php

namespace App\Models;

use App\Enums\GatewayType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => GatewayType::class,
    ];

    public function scopeCode($query, $code)
    {
        return $query->where('gateway_code', $code);
    }
}
