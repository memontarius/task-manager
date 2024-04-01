<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'social_id',
        'token',
        'refresh_token',
    ];
}
