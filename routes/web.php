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
