<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes_Album extends Model
{
    protected $fillable = [
        'user_id', 'album_id',
    ];
}
