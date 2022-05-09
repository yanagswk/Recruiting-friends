<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameMaster extends Model
{
    use HasFactory;

    protected $table = 'game_master';

    protected $fillable = [
        'game_name',
        'url_name',
        'game_image_url',
        // 'hardware_id',
        'created_at',
        'updated_at'
    ];

    public function hardware()
    // public function hardwareHasOne()
    {
        return $this->hasOne(HardwareMaster::class, 'hardware_id', 'hardware_id');
    }

    public function hardwareFriend()
    {
        return $this->hasMany(HardwareFriendMaster::class, 'game_id', 'id');
    }

    public function userRecruitment()
    {
        return $this->hasOne(userRecruitment::class, 'game_id', 'id');
    }

    /**
     * リレーション先 hardware_master取得
     * 中間テーブル game_hardware
     */
    public function hardwareToMany()
    {
        return $this->belongsToMany(
            HardwareMaster::class,      // 接続先モデル
            'game_hardware',            // 中間テーブル名
            'game_id',                  // 接続元モデルを示す中間テーブルのidカラム
            'hardware_id',              // 接続先モデルを示す中間テーブルのidカラム
            'id',                       // 接続元のidカラム
            'id'                        // 接続先のidカラム
        );
    }

    /**
     * リレーション先 friend_master取得
     * 中間テーブル game_friend
     */
    public function friend()
    {
        return $this->belongsToMany(
            FriendMaster::class,
            'game_friend',
            'game_id',
            'friend_id',
            'id',
            'id'
        );
    }

    /**
     * TODO:追加
     */
    public function scopeActive($query)
    {
        $query->where('is_invalid', 0);
    }
}