<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hui extends Model
{
    protected $table = 'hui';
    public $fillable = ['users_id','says_id','addtime','hui_content','commit_id'];
    public $timestamps = false;
}
