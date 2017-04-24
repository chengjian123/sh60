<?php

namespace App\Http\Controllers\Home;

use App\Collection;
use App\Commit;
use App\Follow;
use App\Http\Requests\HomeLogin;
use App\Http\Requests\HomePush;
use App\Http\Requests\HomePushPing;
use App\Http\Requests\HomeRegister;
use App\Hui;
use App\Post;
use App\Say;
use App\Http\Controllers\Home;
use App\User;
use App\Zan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    //
    public function index()
    {
        return view('home.index');
    }

    //注册
    public function register()
    {
        return view('home.register');
    }

    //执行注册
    public function doRegister(HomeRegister $request)
    {
        //dd($request->all());
        //需要添加到数据库里的东西
        $data=[
            'avatar'=>'/home/images/1.png',
            'confirmed_code'=>str_random(10),
        ];
        $user = User::create(array_merge($request->all(),$data));
     //   dd($user);
        $view = ('home.emailConfirmed');
        $subject = '请验证邮箱';
//        dd($user);
        //发送邮件
        $this->sendEmail($user,$view,$subject,$data);//固定4个参数
        return redirect('home/index');
    }

    public function sendEmail($user,$view,$subject,$data)
    {
        Mail::send($view, $data, function ($m) use ($subject,$user) {
            $m->to($user->email)->subject($subject);
        });
    }

    //验证邮箱后,邮箱内跳转页面
    public function emailConfirmed($code)
    {
        //查询与之匹配的数据
        $user = User::where('confirmed_code',$code)->first();
//        dd($user);
        if(is_null($user)){
            return redirect('home/index');
        }
        $user->confirmed_code = str_random(10);
        $user->is_confirmed = 1;
        $user->save();
        return redirect('home/login');
    }

    //登录
    public function login()
    {
        return view('Home.login');
    }

    //执行登录
    public function doLogin(HomeLogin $request)
    {
        $login = Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')]);

        if($login){
            return redirect('home/personal');
        }
    }

    //登录完成后退出
    public function loginout()
    {
        Auth::logout();
        return redirect('home/index');
    }

    public function Ftime($time)
    {
        $rtime = date("m-d H:i",$time);
        $htime = date("H:i",$time);
        $time = time() - $time;

        if ($time < 60) {
            $str = '刚刚';
        }
        elseif ($time < 60 * 60) {
            $min = floor($time/60);
            $str = $min.'分钟前';
        }
        elseif ($time < 60 * 60 * 24) {
            $h = floor($time/(60*60));
            $str = $h.'小时前 '.$htime;
        }
        elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time/(60*60*24));
            if($d==1)
                $str = '昨天 '.$rtime;
            else
                $str = '前天 '.$rtime;
        }
        else {
            $str = $rtime;
        }
        return $str;
    }

    public function push()
    {
         $id = Auth::user()->id;
        //根据模型将所以的数据查询出来
        $users = User::where('id','>','0')->get();
        $follow = Follow::where('usersby_id','=',$id)->get();
        $say =Say::where('id','>','0')->orderBy('id','desc')->get();

        foreach ($say as $v){
            $say_id = $v->id;

            $a =  DB::table('collection')
                    ->where('say_id',$say_id)
                    ->get();
            $v->collectionNum = count($a);
        }

        $hui =Hui::where('id','>','0')->orderBy('id','desc')->get();
        $commit =Commit::where('id','>','0')->orderBy('id','desc')->get();

        foreach ($say as $v){
            $say_id = $v->id;

            $c =  DB::table('users_comment')
                ->where('say_id',$say_id)
                ->get();
            $v->commitNum = count($c);
        }

        $zan = Zan::where('id','>','0')->get();

        foreach ($say as $v){
            $say_id = $v->id;

            $b =  DB::table('zan')
                ->where('zsay_id',$say_id)
                ->get();
            $v->is_zan = $b;
            $v->zanNum = count($b);
        }

        $users_id = DB::select('select * from say where users_id = '.$id);
        $follows = Follow::where('users_id','=',$id)->get();
        $count_weibo =count($users_id);
        $count_fans = count($follow);
        $count_fans1 = count($follows);
        $collection = Collection::where('id','>','0')->get();
        while($say){
            return view('home.personal',compact('say','commit','zan','hui','count_weibo','users','count_fans','count_fans1','collection'));
        }

    }

    public function doPush(HomePush $request)
    {
        $user = Auth::user()->id;
        $txt=$request->input('content'); //获取提交的数据
        $txt= htmlspecialchars(stripslashes($txt));
     //   $txt=mysql_real_escape_string(strip_tags($txt),$link); //过滤HTML标签，并转义特殊字符
        if( mb_strlen($txt)<1 ||  mb_strlen($txt)>140){
           return  alert('输入合理的字数');
        }
        $users_id=$user;
      //插入数据到数据表中
        $data=[
            'users_id'=>$users_id,
        ];
        Say::create(array_merge($request->all(),$data));

        return redirect('home/personal');
    }

    public function doPushPing(HomePushPing $request)
    {

        $user = Auth::user()->id;
        $txt=$request->input('commit_content'); //获取提交的数据
        $txt= htmlspecialchars(stripslashes($txt));
        //   $txt=mysql_real_escape_string(strip_tags($txt),$link); //过滤HTML标签，并转义特殊字符
        if( mb_strlen($txt)<1 ||  mb_strlen($txt)>140){
            return  alert('输入合理的字数');
        }
        $users_id=$user;
        //插入数据到数据表中
        //   dd($request->all());
         /*$say_id = $request->input('say_id');*/
        $data=[
            'users_id'=>$users_id,
            'commit_users_id'=>$users_id,
        ];
        Commit::create(array_merge($request->all(),$data));

        return redirect('home/personal');
    }

    public function dodel($id)
    {
        //获取微博模型
        $say = Say::find($id);
        $say->delete();
        return redirect('home/personal');
    }

    public function do_del($id)
    {

        //获取微博模型
        $say = Say::find($id);
        $say->delete();
        return redirect('home/vip');
    }

    public function dodelt($id)
    {
        //获取微博模型
        $commit = Commit::find($id);
        $commit->delete();
        return redirect('home/personal');
    }

    public function dohui(Request $request)
    {
        $user = Auth::user()->id;
        $txt=$request->input('hui_content'); //获取提交的数据
        $txt= htmlspecialchars(stripslashes($txt));
        //   $txt=mysql_real_escape_string(strip_tags($txt),$link); //过滤HTML标签，并转义特殊字符
        if( mb_strlen($txt)<1 ||  mb_strlen($txt)>140){
            return  alert('输入合理的字数');
        }
        $users_id=$user;
        //插入数据到数据表中
        $data=[
            'users_id'=>$users_id,
        ];
        Hui::create(array_merge($request->all(),$data));

        return redirect('home/personal');
    }

}
