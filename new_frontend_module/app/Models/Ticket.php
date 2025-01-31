<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends \Coderflex\LaravelTicket\Models\Ticket
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'attachments' => 'array',
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y h:i A');
    }

    public function scopeUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid)->firstOrFail();
    }

    public function messages(): HasMany
    {
        $tableName = config('laravel_ticket.table_names.messages', 'messages');

        return $this->hasMany(
            Message::class,
            (string) $tableName['columns']['ticket_foreing_id'],
        )->latest();
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
            return $query->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('username', 'like', '%'.$search.'%');
                })->orWhere('uuid', 'like', '%'.$search.'%')
                    ->orWhere('title', 'like', '%'.$search.'%');
            });

        }

        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status && $status != 'all') {
            $query->where('status', $status);
        }

        return $query;
    }
}
