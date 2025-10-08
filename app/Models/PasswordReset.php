<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets_custom';
    protected $fillable = ['email', 'code_hash', 'reset_token', 'expires_at', 'used'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];
}
