<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawDataModel extends Model
{
    protected $fillable = [
        'title',
        'md5_title',
        'description',
        'content',
        'url',
        'image_url',
        'publishedAt',
        'require_crawler',
        'data_response',
        'processed',
        'provider',
    ];
}
