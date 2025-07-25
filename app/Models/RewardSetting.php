<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'visits_required',
        'gift_title',
        'gift_description',
    ];
}
