<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKyc extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kyc()
    {
        return $this->hasOne(Kyc::class,'id','kyc_id');
    }

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime'
    ];
}
