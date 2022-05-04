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
    {
        return $this->hasOne(HardwareMaster::class, 'hardware_id', 'hardware_id');
    }

    /**
     * TODO:追加
     */
    public function scopeActive($query)
    {
        $query->where('is_invalid', 0);
    }
}
