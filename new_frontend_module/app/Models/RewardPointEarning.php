<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardPointEarning extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function portfolio()
    {
        return $this->hasOne(Portfolio::class, 'id', 'portfolio_id');
    }
}
