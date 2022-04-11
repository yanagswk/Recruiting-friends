<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitments extends Model
{
    use HasFactory;

    protected $table = 'recruitment';

    protected $fillable = [
        'game_id',
        'hardware_id',
        'comment',
        'ps_id',
        'steam_id',
        'origin_id',
        'skype_id',
        'discord_id',
        'friend_code_id',
        'is_invalid',
        'created_at',
        'updated_at'
    ];

    public function hardware()
    {
        return $this->hasOne(HardwareMaster::class, 'hardware_id', 'hardware_id');
    }

    /**
     * 有効なテーブル
     */
    public function scopeActive($query)
    {
        $query->where('is_invalid', 0);
    }
}