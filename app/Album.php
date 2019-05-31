<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Photo;

class Album extends Model
{
    protected $fillable = [
        'user_id', 'album_name', 'album_description',
        'cover_picture','privacy'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function photos()
    {
        return $this->hasMany('App\Photo','album_id');
    }
}
