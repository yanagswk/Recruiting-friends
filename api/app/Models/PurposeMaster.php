<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurposeMaster extends Model
{
    use HasFactory;

    protected $table = 'purpose_master';

    public $timestamps = false;     // テーブルにタイムスタンプなし
}