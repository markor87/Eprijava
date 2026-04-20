<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'country_code',
        'city',
        'user_agent',
        'success',
        'failure_reason',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'success'    => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
