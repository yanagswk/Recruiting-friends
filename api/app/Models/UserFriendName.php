<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFriendName extends Model
{
    use HasFactory;

    protected $table = 'user_friend_name';

    protected $fillable = [
        'game_id',
        'hardware_friend_id',
        'friend_name',
        'created_at',
        'updated_at'
    ];
}