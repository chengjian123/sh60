<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VipController extends Controller
{
    //会员列表
    public function vipList()
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
        //定义一个变量接收角色ID
        $roleId = array();
        // 接收管理员和超管角色ID
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
//dump($perms);
        //当前路由对应得权限名称为
        $thisPerm = 'admin/vip';
        $permL =  DB::table('permissions')
            ->where('name',$thisPerm)
            ->get();
        foreach ($permL as $v){
            $permId = $v->id;
        }

        // 查询当前权限id 所有的角色id
        $permR =  DB::table('permission_role')
            ->where('permission_id', $permId)
            ->get();
        foreach ($permR as $v){
            $roleId[] = $v->role_id;
        }
        // 登录者id
        $logId = session()->get('adminUserId');
        $roles = DB::table('role_user')
            ->where('user_id',$logId)
            ->get();

        foreach ($roles as $v){
            $re = $v->role_id;
        }
//        dd($roleId);
        // 判断当前路由是否在登录者路由权限之下
        if(!in_array($re,$roleId)){
            $mess = '此操作是当前用户权限不允许的操作';
            return view('admin/index',compact('mess'));
        }


//        dump($perm);

        // 查询角色 的 id
        $users = DB::table('roles')
            ->where('display_name', '会员用户')
            ->paginate(4);
//        dd($result);
        if(!empty($users[0])){


                foreach ($users as $v){
                    // 获取 普通角色 id

                    $r_id = $v->id;

                }

                // 获取普通角色名称
                $res = DB::table('roles')
                    ->where('id',$r_id)
                    ->get();
                foreach ($res as $v){
                    $display_name = $v->display_name;
                }
        //


                $user = DB::table('role_user')
                    ->where('role_id', $r_id)
                    ->get();
                $arr = array();
                foreach ($user as $v){
                    $arr[] = $v->user_id;
                }
        //        dd($arr);
                $users = DB::table('users')
                    ->whereIn('id',$arr)
                    ->paginate(6);

            $all = DB::table('users')
                ->whereIn('id',$arr)
                ->get();
            $count = count($all);


            return view('admin/vipList', compact('users', 'display_name','count'));
        }else{
            $display_name = '';
            $count = [];

            return view('admin/vipList', compact('users', 'display_name','count'));
        }


    }

    //重置密码
    public function usersRe($id)
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
        $roleId = array();
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
//dump($perms);
        //当前路由对应得权限名称为
        $thisPerm = 'admin/vip';
        $permL =  DB::table('permissions')
            ->where('name',$thisPerm)
            ->get();
        foreach ($permL as $v){
            $permId = $v->id;
        }

        // 查询当前权限id 所有的角色id
        $permR =  DB::table('permission_role')
            ->where('permission_id', $permId)
            ->get();
        foreach ($permR as $v){
            $roleId[] = $v->role_id;
        }
        // 登录者id
        $logId = session()->get('adminUserId');
        $roles = DB::table('role_user')
            ->where('user_id',$logId)
            ->get();

        foreach ($roles as $v){
            $re = $v->role_id;
        }
//        dd($roleId);
        // 判断当前路由是否在登录者路由权限之下
        if(!in_array($re,$roleId)){
            $mess = '此操作是当前用户权限不允许的操作';
            return view('admin/index',compact('mess'));
        }


        $pass = '123456';
        $arr = [
            'password' => Hash::make($pass),
        ];


         DB::table('users')
            ->where('id', $id)
            ->update($arr);

        return redirect('admin/vipList');

    }

    //禁用用户
    public function usersDisable($id)
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
        $roleId = array();
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
//dump($perms);
        //当前路由对应得权限名称为
        $thisPerm = 'admin/vip';
        $permL =  DB::table('permissions')
            ->where('name',$thisPerm)
            ->get();
        foreach ($permL as $v){
            $permId = $v->id;
        }

        // 查询当前权限id 所有的角色id
        $permR =  DB::table('permission_role')
            ->where('permission_id', $permId)
            ->get();
        foreach ($permR as $v){
            $roleId[] = $v->role_id;
        }
        // 登录者id
        $logId = session()->get('adminUserId');
        $roles = DB::table('role_user')
            ->where('user_id',$logId)
            ->get();

        foreach ($roles as $v){
            $re = $v->role_id;
        }
//        dd($roleId);
        // 判断当前路由是否在登录者路由权限之下
        if(!in_array($re,$roleId)){
            $mess = '此操作是当前用户权限不允许的操作';
            return view('admin/index',compact('mess'));
        }


        $arr =[
            'disable' => '-1',
        ];
        DB::table('users')
            ->where('id', $id)
            ->update($arr);
        return redirect('admin/vipList');

    }

    //启用用户
    public function usersAble($id)
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
        $roleId = array();
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
//dump($perms);
        //当前路由对应得权限名称为
        $thisPerm = 'admin/vip';
        $permL =  DB::table('permissions')
            ->where('name',$thisPerm)
            ->get();
        foreach ($permL as $v){
            $permId = $v->id;
        }

        // 查询当前权限id 所有的角色id
        $permR =  DB::table('permission_role')
            ->where('permission_id', $permId)
            ->get();
        foreach ($permR as $v){
            $roleId[] = $v->role_id;
        }
        // 登录者id
        $logId = session()->get('adminUserId');
        $roles = DB::table('role_user')
            ->where('user_id',$logId)
            ->get();

        foreach ($roles as $v){
            $re = $v->role_id;
        }
//        dd($roleId);
        // 判断当前路由是否在登录者路由权限之下
        if(!in_array($re,$roleId)){
            $mess = '此操作是当前用户权限不允许的操作';
            return view('admin/index',compact('mess'));
        }


        $arr =[
            'disable' => '0',
        ];
        DB::table('users')
            ->where('id', $id)
            ->update($arr);
        return redirect('admin/vipList');

    }

    //搜索分页
    public function vipSearch(Request $request)
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

        // 查询角色 的 id
        $users = DB::table('roles')
            ->where('display_name', '会员用户')
            ->paginate(4);
//        dd($result);
        if(!empty($users[0])) {


            foreach ($users as $v) {
                // 获取 普通角色 id

                $r_id = $v->id;

            }

            // 获取普通角色名称
            $res = DB::table('roles')
                ->where('id', $r_id)
                ->get();
            foreach ($res as $v) {
                $display_name = $v->display_name;
            }
            //


            $user = DB::table('role_user')
                ->where('role_id', $r_id)
                ->get();
            $arr = array();
            foreach ($user as $v) {
                $arr[] = $v->user_id;
            }

            $searchName = $request->search;
            //        dd($arr);
            $users = DB::table('users')
                ->whereIn('id', $arr)
                ->where('name','like','%'.$searchName.'%')
                ->paginate(6);

            $all = DB::table('users')
                ->whereIn('id', $arr)
                ->where('name','like','%'.$searchName.'%')
                ->get();
//            dd($all);
            $count = count($all);


            return view('admin/vipList', compact('users', 'display_name', 'count'));
        }

    }

}
