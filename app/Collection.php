<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collection';
    public $fillable = ['users_id','usersby_id','say_id'];
    public $timestamps = false;
}
