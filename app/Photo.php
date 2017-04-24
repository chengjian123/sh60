<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photo';
    public $fillable = ['users_id','photo_name','addtime','album_id'];
    public $timestamps = false;
}
