<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests;
use App\User;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{

    //后台首页
    public function index()
    {

        //验证是否登录
        if(empty(session()->get('adminUser'))){
            $err = 2;
            return view('admin/login', compact('err'));
        }

        // 查询登录者信息
            // 登录者 用户名
        $logName = session()->get('adminUser');
        $res = DB::table('users')
            ->where('name',$logName)
            ->get();
        foreach ($res as $v ){
            $pass = $v->password;
            // 获取登录者id
            $user_id = $v->id;
        }

        // 判断是否是超级管理员或管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if($v->display_name == '管理员'|| $v->display_name == '超级管理员' ){
                // 获取超级管理员和管理员 在users表中的 id
                $arr[] = $v->user_id;
            }


        }
        // 如果登录者id在$arr 中则为管理员或超级管理员，否则不能登陆后台
        if(!in_array($user_id,$arr)){
            $mess = '用户不是管理员或超级管理员';
            $err = 1;
            return view('admin/login',compact('mess','err'));
        }
            $mess = '';
        return view('admin/index',compact('mess'));
    }
    // 后台登录界面
    public function login(Request $request)
    {
        if($request->isMethod('post')){

               $rules = array(
                    'name' => 'required|exists:users',
                    'password' => 'required|between:6,12',
                );

                $mess = array(
                    'name.required' => '用户名不能为空',
                    'name.exists' => '用户名不存在',
                    'password.required' => '密码不能为空',
                    'password.between' => '密码为6到10位字符',
                );

                $this->validate($request,$rules,$mess);
                // 查询登录者信息
                 $res = DB::table('users')
                    ->where('name',$request->name)
                    ->get();
                 foreach ($res as $v ){
                      $pass = $v->password;
                      // 获取登录者id
                      $user_id = $v->id;
                 }

                 // 判断是否是超级管理员或管理员
               $result = DB::table('roles')
                     ->leftJoin('role_user', 'roles.id','role_user.role_id')
                     ->get();
//            dump($result->all());
            $roleId = array();
            $arr = array();
              foreach ($result as $v){

//                  dump($v->display_name);
                   if($v->display_name == '管理员'|| $v->display_name == '超级管理员' ){
                      // 获取超级管理员和管理员 在users表中的 id
                       $arr[] = $v->user_id;
                       $roleId[] = $v->id;

                   }


              }
                // 如果登录者id在$arr 中则为管理员或超级管理员，否则不能登陆后台
                if(!in_array($user_id,$arr)){
                  $mess = '用户不是管理员或超级管理员';
                  $err = 1;
                  return view('admin/login',compact('mess','err'));
                }
//            dd($arr);

            // 两表联查，当登录者是超管或者管理员的时候对应的权限表信息
            $perm = DB::table('permissions')
                ->rightJoin('permission_role','permissions.id','permission_role.permission_id')
                ->whereIn('role_id',$roleId)
                ->get();
            //获取当前路由对应的权限
            $perms = array();
            foreach ($perm as $v){
                $perms[] = $v->name;
            }

            // 判断当前路由是否在登录者路由权限之下

            //当前路由对应得权限名称为
            $thisPerm = 'admin/index';

            if(!in_array($thisPerm,$perms)){
                $mess = '此操作是当前用户权限不允许的操作';
                $err = 1;
                return view('admin/login',compact('mess','err'));
            }


            // 如果允许登录则对密码进行hash 比较，判断密码是否正确
                if (Hash::check($request->password,$pass)){

                        //  如果密码正确则将 登录者 name 和 id 存入session
                     session(['adminUser' => $request->name, 'adminUserId'=>$user_id]);


                    return redirect('admin/index');
                }else{
                    // err = 0 为密码错误
                    $err = 0;
                    return view('admin/login',compact('err'));
                }
        }
        // err = 1 为正常
        $err = 1;

        return view('admin/login',compact('err'));

    }

    //退出 切换用户
    public function logOut()
    {
        //验证是否登录
        if(empty(session()->get('adminUser'))){
            $err = 2;
            return view('admin/login', compact('err'));
        }

        session()->forget('adminUser');
        session()->forget('adminUserId');
//        dd(session()->get('adminUser'));
        return redirect('admin/login');
    }


    //个人信息， 修改个人信息
    public function ownDes(Request $request, $id)
    {
        //验证是否登录
        if(empty(session()->get('adminUser'))){
            $err = 2;
            return view('admin/login', compact('err'));
        }
        // 判断传输方式， post 则为修改个人信息
        if($request->isMethod('post')){

        if($request->password && $request->avatar){


            $rules = array(
                'name' => 'required',
                'email' => 'email',
                'avatar' => 'image|dimensions:max_width=200,max_height=300',
                'password' => 'required|between:6,12',
            );

            $mess = array(
                'name.required' => '用户名不能为空',
                'email.email' => '邮箱格式不正确',
                'avatar.image' => '请上传 jpeg、png、bmp、gif 或者 svg 格式 的图片',
                'avatar.dimensions' => '请上传宽度小于200，高度小于300的图片',
                'password.required' => '密码不能为空',
                'password.between' => '密码为6到10位字符',

            );
            $this->validate($request,$rules,$mess);
            //获取图片格式
            $filetype= $request->avatar->extension();
//            dump($request->avatar );
//            dd($filetype);

            $pic = md5(time()).'.'.$filetype;
            $url = 'admin/images';
            $upUrl =  $request->file('avatar')->storeAs($url ,$pic );

            //查询原有图片
            $userL = DB::table('users')
                    ->where('id',$id)
                    ->get();
            foreach ($userL as $v){
                $ava = $v->avatar;
                // 原用户名
                $userName = $v->name;
                // 原密码
                $password = $v->password;
            }
            if(empty($upUrl)){
                $messages = '上传失败';
               return view('admin/ownDes',compact('messages'));
            }
            // 判断是否是默认头像
            if($ava != 'admin/images/default.jpg'){
                $a =  Storage::delete($ava);
            }

//            dd($a);
//            dd($upUrl);
//            dd($request->all());
            // 新密码
            $newPass = Hash::make($request->password);

            // 新用户名
            $newName = $request->name;
            $data = [
                'name' =>$newName ,
                'email' => $request->email,
                'password' => $newPass ,
                'avatar' => $upUrl ,
            ];
//            dd($data);
            //更新个人信息
            DB::table('users')
                ->where('id',$id)
                ->update($data);

            // 如果用户名或密码更改将清除session并跳转到登录界面
            if($newName != $userName || !Hash::check($request->password,$newPass)){
                session()->forget('adminUser');
                session()->forget('adminUserId');
//        dd(session()->get('adminUser'));
                return redirect('admin/login');
            }

            return redirect('admin/index');


        }else{

           $rules = array(
                'name' => 'required',
                'email' => 'email',


            );

            $mess = array(
                'name.required' => '用户名不能为空',
                'email.email' => '邮箱格式不正确',
            );
            $this->validate($request,$rules,$mess);

            //已存用户名
            $userName = session()->get('adminUser');

            // 新用户名
            $newName = $request->name;
            $data = [
                'name' => $newName,
                'email' => $request->email,
            ];
            DB::table('users')
                ->where('id',$id)
                ->update($data);

            if($newName != $userName ){
                session()->forget('adminUser');
                session()->forget('adminUserId');
//        dd(session()->get('adminUser'));
                return redirect('admin/login');
            }
            return redirect('admin/index');

        }

        }
       $result =  DB::table('users')
            ->where('id',$id)
            ->get();
        return view('admin/ownDes', compact('result', 'id'));
    }

}
