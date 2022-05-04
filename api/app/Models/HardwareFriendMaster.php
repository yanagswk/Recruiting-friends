<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareFriendMaster extends Model
{
    use HasFactory;

    protected $table = 'hardware_friend_master';

    protected $fillable = [
        'game_id',
        'hardware_id',
        'friend_id',
        'created_at',
        'updated_at'
    ];
}
