<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes_Photo extends Model
{
    protected $fillable = [
        'user_id', 'photo_id',
    ];
}
