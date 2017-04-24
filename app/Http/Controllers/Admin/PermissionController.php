<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    //显示列表
    public function permissionList()
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
        $roleId = array();
        foreach ($result as $v){

//                  dump($v->display_name);
            if($v->display_name == '管理员'|| $v->display_name == '超级管理员' ){
                // 获取超级管理员和管理员 在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为管理员或超级管理员，否则不能登陆后台
        if(!in_array($user_id,$arr)){
            $mess = '需是管理员或超级管理员可为的操作';

            return view('admin/index',compact('mess'));
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
        $thisPerm = 'admin/permissionList';
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


        //查询所有的权限
        $permissions = Permission::paginate(6);
//        dd($permissions);
        $mess = '';
        return view('admin/permissionList', compact('permissions','mess'));
    }

    //加载添加权限表单
    public function permissionAdd()
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
            if( $v->display_name == '超级管理员' ){
                // 获取超级管理员 在users表中的 id
                $arr[] = $v->user_id;
            }



        }
        // 如果登录者id在$arr 中则为超级管理员
        if(!in_array($user_id,$arr)){
            $mess = '——>需超级管理员操作';
            $permissions = Permission::paginate(6);
//            dd(11);
            return view('admin/permissionList',compact('mess','permissions'));
        }




         return view('admin.permissionAdd');
    }

    // 添加权限
    public function doPermissionAdd(Request $request)
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
            if( $v->display_name == '超级管理员' ){
                // 获取超级管理员 在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员';
            $permissions = Permission::paginate(6);

            return view('admin/permissionList',compact('mess','permissions'));
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
        $thisPerm = 'admin/permissionList';
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

            //验证注册信息
            $rules = array(
                'name' => 'required',
                'display_name' => 'required|between:1,15',
                'description' => 'required|between:2,30',
            );

            $mess = array(
                'name.required' => '请正确输入权限路由',
                'display_name.required' => '请正确输入权限名称',
                'display_name.between' => '请输入少于15字的内容',
                'description.required' => '请正确输入描述',
                'description.between' => '请输入少于30字的描述',
            );

            $this->validate($request,$rules,$mess);

            //添加权限操作

            $new = new Permission();
            $new->name = $request->name;
            $new->display_name = $request->display_name;
            $new->description = $request->description;
            $new->save();

            return redirect('admin/permissionList');
        }
        return view('admin.permissionAdd');
    }


    //删除权限
    public function permissionDel($permission_id)
    {
        //验证是否登录
        if(empty(session()->get('adminUser'))){
            $err = 2;
            return view('admin/login', compact('err'));
        }
//        dd(11);

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
            if($v->display_name == '超级管理员' ){
                // 获取超级管理员
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员';
            $permissions = Permission::paginate(6);
            return view('admin/permissionList',compact('mess','permissions'));
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
        $thisPerm = 'admin/permissionList';
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

        //删除信息
       Permission::destroy($permission_id);
        return redirect('admin/permissionList');
    }

   //修改权限
    public function permissionUpdate(Request $request, $permission_id)
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
            if( $v->display_name == '超级管理员' ){
                // 获取超级管理员在users表中的 id
                $arr[] = $v->user_id;

            }


        }
        // 如果登录者id在$arr 中则为超级管理员
        if(!in_array($user_id,$arr)){
            $mess = '用户不是超级管理员';
            $permissions = Permission::paginate(6);
            return view('admin/permissionList',compact('mess','permissions'));
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
        $thisPerm = 'admin/permissionList';
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

            //验证注册信息
            $rules = array(
                'name' => 'required',
                'display_name' => 'required|between:1,15',
                'description' => 'required|between:2,30',
            );

            $mess = array(
                'name.required' => '请正确输入权限路由',
                'display_name.required' => '请正确输入权限名称',
                'display_name.between' => '请输入少于15字的内容',
                'description.required' => '请正确输入描述',
                'description.between' => '请输入少于30字的描述',
            );

            $this->validate($request,$rules,$mess);


            $permission = Permission::findOrFail($permission_id);
            $permission->name = $request->name;
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            $permission->save();

            return redirect('admin/permissionList');
        }
        //查询出当前的权限信息
        $permission = Permission::findOrFail($permission_id);

        return view('admin.permissionUpdate', compact('permission'));
    }


    // 根据权限路由进行权限的模糊查询
    public function permSearch(Request $request)
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
        $thisPerm = 'admin/permissionList';
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



        $name = $request->search;
        $permissions = DB::table('permissions')->Where('name', 'like', '%'.$name.'%')->simplePaginate(6);
//dd($permissions);
        return view('admin/permissionSearch')
                ->with('permissions', $permissions);




    }
}
