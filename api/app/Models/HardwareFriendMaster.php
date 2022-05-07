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

    public function hardware()
    {
        return $this->belongsTo(HardwareMaster::class, 'hardware_id', 'id');
        // return $this->hasMany(HardwareMaster::class, 'hardware_id', 'hardware_id');
        // return $this->hasMany(HardwareMaster::class, 'hardware_id', 'hardware_id');
    }

    public function friend()
    {
        return $this->belongsTo(FriendMaster::class, 'friend_id', 'id');
        // return $this->belongsToMany(FriendMaster::class, 'friend_id', 'id');
    }
}
