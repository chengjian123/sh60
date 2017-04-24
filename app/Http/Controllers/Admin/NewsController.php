<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    //新闻列表
    public function newsList()
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
            ->rightJoin('role_user', 'roles.id','role_user.role_id')
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
            $mess = '用户不是管理员或超级管理员';
            $err = 1;
            return view('admin/login',compact('mess','err'));
        }
//dump($result);
        //当前路由对应得权限名称为
        $thisPerm = 'admin/news';

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


        $result = DB::table('users')
            ->rightJoin('news' , 'users.id', 'news.users_id')
            ->paginate(6);
        foreach ($result as $v){
              $type_id = $v->type_id;
            $type = DB::table('type')
                ->where('id',$type_id)
                ->get();
            //根据类型id 查找类型名，并添加到对应的结果中
            foreach ($type as $vl){
                $typeL = $vl->name;
            }
            $v->type = $typeL;

        }

        $all = DB::table('news')
                ->get();
        $count = count($all);


        return view('admin/newsOrderList', compact('result','count'));

    }

    //修改新闻类型
    public function newsType(Request $request, $id)
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
        $thisPerm = 'admin/news';
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
            $data = [
                'type_id' => $request->type_id,
            ];
            DB::table('news')
                ->where('id',$id)
                ->update($data);

            return redirect('admin/newsList');
        }

        $types = DB::table('type')
                ->get();


        return view('admin/typeList',compact('types','id'));

    }

    //删除新闻
    public function newsDel($id)
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
        $thisPerm = 'admin/news';
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

        DB::table('news')
            ->where('id',$id)
            ->delete();

            return redirect('admin/newsList');



    }

    //新闻发布
    public function newsRelease(Request $request)
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
        $thisPerm = 'admin/news';
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
//             session(['logAdminUserId' => '12']);

             //验证信息
             $rules = array(
                 'type_id' => 'required',
                 'title' => 'required|between:1,30',
                 'article_content' => 'required|between:1,10000',

             );

             $mess = array(
                 'type_id.required' => '请选择类型',
                 'title.required' => '请输入标题',
                 'title.between' => '请输入少于30字的内容',
                 'article_content.required' => '请输入内容',
                 'article_content.between' => '请输入少于10000字的描述',
             );

             $this->validate($request,$rules,$mess);

             $data = [
                 'title' => $request->title,
                 'type_id' => $request->type_id,
                 'content' => $request->article_content,
//                 获取管理员id
                 'users_id' => $request->session()->get('adminUserId'),
             ];
            DB::table('news')
                ->insert($data);
            return redirect('admin/newsList');
         }
        $types = DB::table('type')
             ->get();
//         dd($types);
         return view('admin/newsRelease',compact('types'));
    }

    //查看内容详情
    public function newsDes($id)
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
        $thisPerm = 'admin/news';
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

        //查询对应新闻信息
        $result = DB::table('news')
                ->where('id',$id)
                ->get();

        //查找新闻类别id
        foreach ($result as $v){
            $type_id = $v->type_id;
        }

        $types = DB::table('type')
                ->where('id',$type_id)
                ->get();
//        dd($result);
        return view('admin/newsContent',compact('result','types'));
    }

    //新闻类别列表
    public function newsTypeList()
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

         $types = DB::table('type')
            ->get();
        return view('admin/newsTypeList',compact('types'));
    }

    // 新增新闻类别
    public function typeAdd(Request $request)
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
        $thisPerm = 'admin/news';
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


        if ($request->isMethod('post')){

            //验证信息
            $rules = array(
                'name' => 'required',


            );

            $mess = array(
                'name.required' => '请输入新闻类别',
            );

            $this->validate($request,$rules,$mess);

            $data = [
                'name' => $request->name,
            ];
            DB::table('type')
                ->insert($data);

            return redirect('admin/newsTypeList');
        }

        return view('admin/typeAdd');
    }

    //删除新闻类别
    public function newsTypeDel($id)
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
        $thisPerm = 'admin/news';
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

        DB::table('type')
            ->where('id',$id)
            ->delete();
        return redirect('admin/newsTypeList');
    }

    //新闻搜索分页

    public function newsSearch(Request $request)
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
            ->rightJoin('role_user', 'roles.id','role_user.role_id')
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
            $mess = '用户不是管理员或超级管理员';
            $err = 1;
            return view('admin/login',compact('mess','err'));
        }
        // 所有数据
        $searchTitle = $request->search;

        $result = DB::table('users')
            ->rightJoin('news' , 'users.id', 'news.users_id')
            ->where('title','like','%'.$searchTitle.'%')
            ->paginate(6);
        foreach ($result as $v){
            $type_id = $v->type_id;
            $type = DB::table('type')
                ->where('id',$type_id)
                ->get();
            //根据类型id 查找类型名，并添加到对应的结果中
            foreach ($type as $vl){
                $typeL = $vl->name;
            }
            $v->type = $typeL;

        }

        // 分页数据
        // 搜索内容

        $all = DB::table('users')
            ->rightJoin('news' , 'users.id', 'news.users_id')
            ->where('title','like','%'.$searchTitle.'%')
            ->get();
        foreach ($result as $v){
            $type_id = $v->type_id;
            $type = DB::table('type')
                ->where('id',$type_id)
                ->get();
            //根据类型id 查找类型名，并添加到对应的结果中
            foreach ($type as $vl){
                $typeL = $vl->name;
            }
            $v->type = $typeL;

        }

//        dd($all);
        $count = count($all);


        return view('admin/newsOrderList', compact('result','count'));


    }


}





