<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //管理员列表
    public function usersList()
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

        // 判断是否是超级管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        $roleId = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if( $v->display_name == '超级管理员' || $v->display_name == '管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员，
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员 或管理员';
            $permissions = Permission::paginate(6);
            return view('admin/login',compact('mess','permissions'));
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
        $thisPerm = 'admin/usersList';
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


        $users = User::paginate(6);
        foreach ($users as $user) {
            $roles = array();

            foreach ($user->roles as $role) {
//                dd($role->display_name);
                $roles[] = $role->display_name;
            }
            $user->roles= implode(',', $roles);
        }
        // 统计数据
          $all = User::all();

        $count = count($all);

          return view('admin/usersList', compact('users','count'));

    }

    //分配角色
    public function usersFen(Request $request, $user_id)
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
            $userL_id = $v->id;
        }

        // 判断是否是超级管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        $roleId = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if( $v->display_name == '超级管理员' || $v->display_name == '管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员，
        if(!in_array($userL_id,$arr)){
            $mess = '用户不是超级管理员 或管理员';
            $permissions = Permission::paginate(6);
            return view('admin/login',compact('mess','permissions'));
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
        $thisPerm = 'admin/usersList';
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


        if ($request->isMethod('post')) {
            //获取当前用户的角色
            $user = User::find($user_id);
            DB::table('role_user')->where('user_id', $user_id)->delete();
            foreach ($request->input('role_id') as $role_id){
                $user->attachRole(Role::find($role_id));
            }
            return redirect('admin/usersList');
        }
        $users = Role::all();
//        dd($user_id);
        return view('admin/usersFen', compact('users','user_id'));
    }

    //删除管理员
    public function usersDel($user_id)
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

        // 判断是否是超级管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        $roleId = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if( $v->display_name == '超级管理员' || $v->display_name == '管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员，
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员 或管理员';
            $permissions = Permission::paginate(6);
            return view('admin/login',compact('mess','permissions'));
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
        $thisPerm = 'admin/usersList';
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


        $user = DB::table('role_user')->where('user_id',$user_id)->delete();
        $user = DB::table('users')->where('id',$user_id)->delete();

        return  redirect('admin/usersList');

    }

    //删除管理员角色
    public function usersDelRole($user_id)
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
            $userL_id = $v->id;
        }

        // 判断是否是超级管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        $roleId = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if( $v->display_name == '超级管理员' || $v->display_name == '管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员，
        if(!in_array($userL_id,$arr)){
            $mess = '用户不是超级管理员 或管理员';
            $permissions = Permission::paginate(6);
            return view('admin/login',compact('mess','permissions'));
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
        $thisPerm = 'admin/usersList';
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


        $user = DB::table('role_user')->where('user_id',$user_id)->delete();


        return  redirect('admin/usersList');

    }

    //新增管理员
    public function usersAdd(Request $request)
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

        // 判断是否是超级管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        $roleId = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if( $v->display_name == '超级管理员' || $v->display_name == '管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员，
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员 或管理员';
            $permissions = Permission::paginate(6);
            return view('admin/login',compact('mess','permissions'));
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
        $thisPerm = 'admin/usersList';
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


        if($request->isMethod('post')){


            //验证注册信息
            $rules = array(
                'name' => 'required',
                'email' => 'email|required',
                'password' => 'required|between:6,12',
            );

            $mess = array(
                'name.required' => '用户名不能为空',
                'email.required' => '邮箱不能为空',
                'email.email' => '邮箱格式不正确',
                'password.required' => '密码不能为空',
                'password.between' => '密码为6到10位字符',
            );

            $this->validate($request,$rules,$mess);

             $data = array(
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
                 'avatar' => 'admin/images/defult.jpg',

             );
             DB::table('users')
                 ->insert($data);
             return redirect('admin/usersList');
         }

        return view('admin/usersAdd');
    }

    //修改管理员
    public function usersUpdate(Request  $request,$user_id)
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

        // 判断是否是超级管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        $roleId = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if( $v->display_name == '超级管理员' || $v->display_name == '管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员，
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员 或管理员';
            $permissions = Permission::paginate(6);
            return view('admin/login',compact('mess','permissions'));
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
        $thisPerm = 'admin/usersList';
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


        if($request->isMethod('post')){

            //验证注册信息
           if(!empty($request->password)) {


                   $rules = array(
                       'name' => 'required',
                       'email' => 'email|required',
                       'password' => 'required|between:6,12',
                   );

                   $mess = array(
                       'name.required' => '用户名不能为空',
                       'email.required' => '邮箱不能为空',
                       'email.email' => '邮箱格式不正确',
                       'password.required' => '密码不能为空',
                       'password.between' => '密码为6到10位字符',
                   );

                   $this->validate($request, $rules, $mess);

                   $data = array(
                       'name' => $request->name,
                       'email' => $request->email,
                       'password' => Hash::make($request->password),
                   );
//                dd($data);

             }else{
               $rules = array(
                   'name' => 'required',
                   'email' => 'email|required',

               );

               $mess = array(
                   'name.required' => '用户名不能为空',
                   'email.required' => '邮箱不能为空',
                   'email.email' => '邮箱格式不正确',

               );

               $this->validate($request, $rules, $mess);

               $data = array(
                   'name' => $request->name,
                   'email' => $request->email,

               );

           }
            $res = DB::table('users')
                ->where('id', $user_id)
                ->update($data);

            return redirect('admin/usersList');

            }
            $user = User::find($user_id);
            return view('admin/usersUpdate', compact('user' ,'user_id'));
    }

    // 搜索分页
    public function usersSearch(Request $request)
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

        // 判断是否是超级管理员
        $result = DB::table('roles')
            ->leftJoin('role_user', 'roles.id','role_user.role_id')
            ->get();
//            dump($result->all());
        $arr = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if( $v->display_name == '超级管理员' || $v->display_name == '管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;
            }


        }
        // 如果登录者id在$arr 中则为超级管理员，
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员 或管理员';
            $permissions = Permission::paginate(6);
            return view('admin/login',compact('mess','permissions'));
        }

        $name = $request->search;
        $users = DB::table('roles')
                ->leftJoin('role_user','roles.id','role_user.role_id')
                ->Where('display_name', 'like', '%'.$name.'%')
                ->paginate(6);
//        $a = count($users);
//        dump($users);

        foreach ($users as $user) {
//            dump($user->user_id);
            $roles= $user->user_id;
            $userL = DB::table('users')
                ->where('id',$roles)
                ->get();
            foreach ($userL as $v){
                $user->name = $v->name;
                $user->email = $v->email;
                $user->roles = $user->display_name;
//                dump($user->name);
            }


        }
//        dd($users);
        $all = DB::table('roles')
            ->leftJoin('role_user','roles.id','role_user.role_id')
            ->Where('display_name', 'like', '%'.$name.'%')
            ->get();

        $count = count($all);

        return view('admin/usersList', compact('users','count'));


    }


}