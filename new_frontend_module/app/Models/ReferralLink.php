<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ReferralLink extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'referral_program_id'];

    public static function getReferral($user, $program)
    {
        return static::firstOrCreate([
            'user_id' => $user->id,
            'referral_program_id' => $program->id,
        ]);
    }

    protected static function boot()
    {
        static::creating(function (ReferralLink $model) {
            $model->generateCode();
        });
        parent::boot();
    }

    private function generateCode()
    {
        $this->code = Str::random(setting('referral_code_limit', 'global'));
    }

    public function getLinkAttribute()
    {
        return url($this->program->uri).'?invite='.$this->code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        // TODO: Check if second argument is required
        return $this->belongsTo(ReferralProgram::class, 'referral_program_id');
    }

    public function relationships()
    {
        return $this->hasMany(ReferralRelationship::class);
    }
}
