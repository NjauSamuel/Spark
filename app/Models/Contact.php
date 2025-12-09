<?php

namespace App\Models;

use App\Events\ContactCreated;
use App\Events\ContactUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'status',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Contact $contact) {
            event(new ContactCreated($contact));
        });

        static::updated(function (Contact $contact) {
            event(new ContactUpdated($contact));
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
