<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'admin'], function () {
    //登录
    Route::any('login', 'Admin\IndexController@login');
    //退出 切换用户
    Route::get('logOut', 'Admin\IndexController@logOut');
    //个人信息， 修改个人信息
    Route::any('ownDes/{id}', 'Admin\IndexController@ownDes');

    //后台首页
    Route::get('index', 'Admin\IndexController@index');
    //  权限管理
    //显示权限列表
    Route::get('permissionList','Admin\PermissionController@permissionList');
    //加载新增权限表单
    Route::get('permissionAdd','Admin\PermissionController@permissionAdd');
    //添加权限
    Route::any('doPermissionAdd','Admin\PermissionController@doPermissionAdd');
    //删除权限
    Route::get('permissionDel/{permission_id}','Admin\PermissionController@permissionDel');
    //修改权限
    Route::any('permissionUpdate/{permission_id}','Admin\PermissionController@permissionUpdate');
    //权限搜索
    Route::any('permSearch', 'Admin\PermissionController@permSearch');

    //  角色管理
    //角色列表
    Route::any('roles','Admin\RolesController@rolesList');
    //新增权限
    Route::any('rolesAdd','Admin\RolesController@roleAdd');
    //分配权限
    Route::any('attachPermission/{role_id}', 'Admin\RolesController@attachPermission');
    //删除权限
    Route::any('rolesDel/{id}', 'Admin\RolesController@rolesDel');
    //修改权限
    Route::get('rolesUpdate/{role_id}', 'Admin\RolesController@rolesUpdate');
    Route::post('roleUpdate/{role_id}', 'Admin\RolesController@roleUpdate');
    // 搜索分页
    Route::any('roleSearch','Admin\RolesController@roleSearch');


    //管理员列表
    Route::get('usersList', 'Admin\UserController@usersList');
   //分配角色
    Route::any('usersFen/{userL_id}','Admin\UserController@usersFen');
    //删除角色
    Route::get('usersDelRole/{user_id}', 'Admin\UserController@usersDelRole');
    //删除管理员
    Route::get('usersDel/{user_id}', 'Admin\UserController@usersDel');
    //新增管理员表单
    Route::any('usersAdd', 'Admin\UserController@usersAdd');
    Route::any('usersUpdate/{user_id}','Admin\UserController@usersUpdate');
    // 搜索分页
    Route::any('usersSearch','Admin\UserController@usersSearch');

    //用户管理
    Route::get('UserList', 'Admin\UsersController@userList');
    //搜索分页
    Route::any('UserSearch', 'Admin\UsersController@UserSearch');
    //重置用户密码
    Route::get('usersRe/{id}', 'Admin\UsersController@usersRe');
    //禁用用户
    Route::get('usersDisable/{id}', 'Admin\UsersController@usersDisable');
    //启用用户
    Route::get('usersAble/{id}', 'Admin\UsersController@usersAble');

    //会员列表
    Route::get('vipList', 'Admin\VipController@vipList');
    //重置用户密码
    Route::get('usersVipRe/{id}', 'Admin\VipController@usersRe');
    //禁用用户
    Route::get('usersVipDisable/{id}', 'Admin\VipController@usersDisable');
    //启用用户
    Route::get('usersVipAble/{id}', 'Admin\VipController@usersAble');
    //搜索分页
    Route::any('vipSearch','Admin\VipController@vipSearch');

    //企业列表
    Route::get('companyList','Admin\CompanyController@companyList');
    //重置企业用户密码
    Route::get('companyRe/{id}', 'Admin\CompanyController@companyRe');
    //禁用企业用户
    Route::get('companyDisable/{id}', 'Admin\CompanyController@companyDisable');
    //启用企业用户
    Route::get('companyAble/{id}', 'Admin\CompanyController@companyAble');
    // 搜索分页
    Route::any('companySearch','Admin\CompanyController@companySearch');


    //新闻列表
    Route::get('newsList','Admin\NewsController@newsList');
    //修改类型
    Route::any('newsType/{id}','Admin\NewsController@newsType');
    //删除新闻
    Route::get('newsDel/{id}','Admin\NewsController@newsDel');
    //新闻发布
    Route::any('newsRelease','Admin\NewsController@newsRelease');
    //查看内容
    Route::get('newsDes/{id}','Admin\NewsController@newsDes');
    // 新闻类别列表
    Route::get('newsTypeList','Admin\NewsController@newsTypeList');
    //新增新闻类型
    Route::any('typeAdd','Admin\NewsController@typeAdd');
    //删除类别
    Route::get('newsTypeDel/{id}','Admin\NewsController@newsTypeDel');
    // 搜索分页
    Route::any('newsSearch','Admin\NewsController@newsSearch');

});


