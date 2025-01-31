<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(Page::class)->withDefault();
    }

    public function getTnameAttribute()
    {
        if ($this->translate != null) {
            $jsonData = json_decode($this->translate, true);
        }

        return $jsonData[session()->get('locale') ?? config('app.locale')] ?? $this->name;
    }
}
