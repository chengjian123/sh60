<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follow';
    public $fillable = ['users_id','usersby_id'];
    public $timestamps = false;

}
