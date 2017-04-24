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
<<<<<<< HEAD

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


=======
/*Route::get('/','home\IndexController@Index');
Route::get('/register','home\UserController@register');
Route::get('/login','home\UserController@login');*/

Route::get('home/index','Home\IndexController@index');
Route::get('home/register','Home\IndexController@register');//注册表单里数据
Route::post('home/register','Home\IndexController@doRegister');//执行注册
//验证邮箱后,邮箱内跳转页面
Route::get('verify/{confirmed_code}','Home\IndexController@emailConfirmed');

Route::get('home/login','Home\IndexController@login');//登录
Route::post('home/login','Home\IndexController@doLogin');//执行登录
Route::get('home/loginout','Home\IndexController@loginout');//退出


// 发布微博
Route::get('home/personal','Home\IndexController@push');//显示微博页
Route::post('home/personal','Home\IndexController@doPush');//发布微博页面
Route::get('home/del-1/{id}','Home\IndexController@dodel');//删除微博



//微博评论
Route::post('home/Ping','Home\IndexController@doPushPing');//评论
Route::get('home/del-2/{id}','Home\IndexController@dodelt');//删除评论
Route::post('home/hui','Home\IndexController@dohui');  //回复评论



//前台微博 相册相册管理
Route::get('home/vip','Home\UserController@index'); //显示vip页面
Route::post('home/Ping-vip','Home\UserController@doPushPing');//评论
Route::get('home/photo','Home\UserController@album');//相册页
Route::get('home/photo/{id}','Home\UserController@album_other');//相册页
Route::post('home/photo','Home\UserController@doalbum');//创建相册
Route::post('home/upphoto','Home\UserController@upphoto');//上传相片 相册外
Route::post('home/up_photo/{id}','Home\UserController@up_photo');//上传相片 相册内
Route::get('home/del_album/{id}','Home\UserController@del_album');//删除相册
Route::get('home/photo-1/{id}','Home\UserController@photo');//相片页


//前台点赞
Route::get('home/zan/{id}','Home\UserController@zan');  //点赞


//前台微博管理
Route::get('home/weibo','Home\UserController@weibo'); //微博管理页显示
Route::get('home/del-2/{id}','Home\IndexController@do_del');//删除微博


//前台微博关注
Route::get('home/other_per/{id}','Home\UserController@other_per'); //其他用户个人主页
Route::get('home/vip_follow','Home\UserController@vip_follow');//关注页面
Route::get('home/guanzhu/{id}','Home\UserController@guanzhu'); //关注
Route::get('home/nozhu/{id}','Home\UserController@nozhu'); //取消关注


//前台粉丝管理
Route::get('home/vip_fans','Home\UserController@vip_fans'); //用户粉丝页

//前台用户收藏
Route::get('home/collection/{id}','Home\UserController@collection'); //用户收藏
>>>>>>> 7d4554fb642b0525ecda6383d1983e3b1f21bc31
