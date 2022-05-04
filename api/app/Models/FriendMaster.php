<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendMaster extends Model
{
    use HasFactory;

    protected $table = 'friend_master';

    protected $fillable = [
        'friend_id_name',
    ];
}
