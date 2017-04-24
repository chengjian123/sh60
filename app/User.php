<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
<<<<<<< HEAD
use Zizaco\Entrust\Traits\EntrustUserTrait;
=======
use Illuminate\Support\Facades\Hash;
use Overtrue\LaravelFollow\CanFollow;
use Overtrue\LaravelFollow\CanBeFollowed;
use Jcc\LaravelVote\Vote;
/*use Zizaco\Entrust\Traits\EntrustUserTrait;*/
>>>>>>> 7d4554fb642b0525ecda6383d1983e3b1f21bc31

class User extends Authenticatable
{
    use Notifiable;
<<<<<<< HEAD
    use EntrustUserTrait;
=======
    use Vote;
    use CanFollow, CanBeFollowed;
>>>>>>> 7d4554fb642b0525ecda6383d1983e3b1f21bc31

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
        'name', 'email', 'password','display_name','description','role_id',
=======
        'name', 'email', 'password','avatar','confirmed_code'
>>>>>>> 7d4554fb642b0525ecda6383d1983e3b1f21bc31
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
<<<<<<< HEAD
        'password', 'remember_token','_token',
    ];
    public $timestamps = false;
=======
        'password', 'remember_token',
    ];

    //    前台注册密码加密
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
>>>>>>> 7d4554fb642b0525ecda6383d1983e3b1f21bc31
}
