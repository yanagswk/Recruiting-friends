<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareMaster extends Model
{
    use HasFactory;

    protected $table = 'hardware_master';

    protected $fillable = [
        'hardware_id',
        'hardware_name',
        'hardware_image_url',
        'created_at',
        'updated_at'
    ];
}