<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareMaster extends Model
{
    use HasFactory;

    protected $table = 'hardware_master';

    public const PS4 = 1;
    public const PS5 = 2;
    public const PS4PS5 = 3;    // PS4とPS5両方

    protected $fillable = [
        'hardware_id',
        'hardware_name',
        'hardware_image_url',
        'created_at',
        'updated_at'
    ];

}