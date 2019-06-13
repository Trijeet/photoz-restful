<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes_album extends Model
{
    protected $fillable = [
        'user_id', 'album_id',
    ];
}
