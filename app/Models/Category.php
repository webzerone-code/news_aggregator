<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'keywords',
    ];
    protected $casts = [
        'keywords' => 'array',
    ];
}
