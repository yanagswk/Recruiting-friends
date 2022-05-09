<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecruitment extends Model
{
    use HasFactory;

    protected $table = 'user_recruitment';

    protected $fillable = [
        'game_id',
        'hardware_id',
        'comment',
        'is_invalid',
        'created_at',
        'updated_at'
    ];

    public function hardware()
    {
        return $this->hasOne(HardwareMaster::class, 'id', 'hardware_id');
    }

    public function friendName()
    {
        return $this->hasMany(UserFriendName::class, 'recruitment_id', 'id');
    }

    /**
     * 有効なテーブル
     */
    public function scopeActive($query)
    {
        $query->where('is_invalid', 0);
    }
}