<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zan extends Model
{
    protected $table = 'zan';
    public $fillable = ['users_id','is_zan','usersby_id','zsay_id'];
    public $timestamps = false;
}
