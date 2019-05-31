<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Album;

class Photo extends Model
{
    protected $fillable = [
        'photo', 'album_id', 'photo_description','privacy'
    ];
    public function album()
    {
        return $this->belongsTo('App\Album','album_id');
    }
}
