<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    protected $table = 'users_comment';
    public $fillable = ['users_id','commit_content','commit_time','type_id','commit_users_id','say_id'];
    public $timestamps = false;
}
