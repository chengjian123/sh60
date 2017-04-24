<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Say extends Model
{
    protected $table = 'say';
    public $fillable = ['users_id','content','addtime'];
    public $timestamps = false;

}
