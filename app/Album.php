<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'album';
    public $fillable = ['users_id','album_name','addtime'];
    public $timestamps = false;
}
