<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'level',
        'hp',
        'attack',
        'defense',
        'speed',
        'height',
        'weight',
        'types',
    ];

    protected $casts = [
        'types' => 'array',
    ];
}
