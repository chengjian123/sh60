<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp">


    <title>@yield('title')</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="{{asset('admin/common/css/sccl.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/common/skin/qingxin/skin.css')}}" id="layout-skin">
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.css')}}">
    <style>

        #menuL ul{
            display:none;
                }
        #menuL h3{
            cursor:pointer;
        }
    </style>

    <script src="{{asset('/admin/js/jquery-1.8.3.min.js')}}"></script>
    <script type="text/javascript">

        $(function() {
            $('#menuL h3').click(function () {
                //当前h3的下一个ul做下拉切换，其他的ul全部关闭
                $(this).next('ul').slideToggle('slow').siblings('ul').slideUp();
            })
        })
    </script>
@yield('heahScript')
<body style="zoom: 1;">
<div class="layout-admin">
    <header class="layout-header">
        <span class="header-logo">新浪微博后台管理中心</span>
        <a class="header-menu-btn" href="javascript:;"><i class="icon-font">&#xe600;</i></a>
        <ul class="header-bar">

            <li class="header-bar-nav">
                    欢迎
                <li class="header-bar-nav">
                   <a href="javascript:;">{{session()->get('adminUser')}}<i class="icon-font" style="margin-left:5px;">&#xe60c;</i></a>
                    <ul class="header-dropdown-menu">
                        <li><a href="{{url('admin/ownDes').'/'.session()->get('adminUserId')}}">个人信息</a></li>
                        <li><a href="{{url('admin/logOut')}}">切换账户</a></li>
                        <li><a href="{{url('admin/logOut')}}">退出</a></li>
                    </ul>

                </li>
            </li>

            <li class="header-bar-nav">
                <a href="javascript:;" title="换肤">皮肤切换<i class="icon-font">&#xe608;</i></a>
                <ul class="header-dropdown-menu right dropdown-skin">
                    <li><a href="javascript:;" data-val="qingxin" id="qingxin" title="清新">清新</a></li>
                    <li><a href="javascript:;" data-val="blue" id="blue" title="蓝色">蓝色</a></li>
                    <li><a href="javascript:;" data-val="molv" id="molv" title="墨绿">墨绿</a></li>

                </ul>
            </li>

        </ul>
    </header>


    <aside class="layout-side">

        <div class="list-group">
            <div id='menuL'>
                <h3 class="list-group-item active">系统管理</h3>
                <ul class="list-group ">
                    <li class="list-group-item"><a href="{{url('admin/permissionList')}}" class="list-group-item active">权限管理</a></li>
                    <li class="list-group-item"><a href="{{url('admin/roles')}}" class="list-group-item active">角色管理</a></li>
                    <li class="list-group-item"><a href="{{url('admin/usersList')}}" class="list-group-item active">管理员管理</a></li>
                </ul>
                <h3 class="list-group-item active">用户管理</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{url('admin/UserList')}}" class="list-group-item active">用户列表</a></li>
                </ul>
                <h3 class="list-group-item active">会员管理</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{url('admin/vipList')}}" class="list-group-item active">会员列表</a></li>
                    <li class="list-group-item"><a href="#" class="list-group-item active">会员推广</a></li>
                    <li class="list-group-item"><a href="#" class="list-group-item active">会员置顶</a></li>
                </ul>
                <h3 class="list-group-item active">营销推广</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="#" class="list-group-item active">广告管理</a></li>
                </ul>
                <h3 class="list-group-item active">新闻管理</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{url('admin/newsList')}}" class="list-group-item active">新闻列表</a></li>
                    <li class="list-group-item"><a href="{{url('admin/newsTypeList')}}" class="list-group-item active">新闻类别</a></li>
                    <li class="list-group-item"><a href="{{url('admin/newsRelease')}}" class="list-group-item active">新闻发布</a></li>
                </ul>
                <h3 class="list-group-item active">留言管理</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="#" class="list-group-item active">留言列表</a></li>
                </ul>
                <h3 class="list-group-item active">企业管理</h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{url('admin/companyList')}}" class="list-group-item active">企业列表</a></li>
                </ul>
            </div>
        </div>


    </aside>

    <div class="layout-side-arrow"><div class="layout-side-arrow-icon"><i class="icon-font">&#xe618;</i></div></div>

    <section class="layout-main">
        <div class="layout-main-tab">
            <button class="tab-btn btn-left"><i class="icon-font"></i></button>
            <nav class="tab-nav">
                <div class="tab-nav-content" id="titleS">
                    <a href="{{url('admin/index')}}" class="content-tab active" data-id="home.html">首页</a>
                </div>
                <div class="tab-nav-content" id="titleL">
                    <a href="" class="content-tab active" data-id="home.html">@yield('title')</a>
                </div>
            </nav>
            <button class="tab-btn btn-right"><i class="icon-font"></i></button>
        </div>
        <div class="layout-main-body">


            @yield('iframe')

        </div>

    </section>
    <div class="layout-footer">@新浪微博2009-2017 </div>

</div>
@yield('script')
{{--<script type="text/javascript" src="{{asset('admin/common/lib/jquery-1.9.0.min.js')}}"></script>--}}
<script type="text/javascript" src="{{asset('admin/common/js/sccl.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/common/js/sccl-util.js')}}"></script>
<script>

    $('#qingxin').click(function () {
             $('#layout-skin').attr('href', '/admin/common/skin/qingxin/skin.css')
    })
    $('#blue').click(function () {
        $('#layout-skin').attr('href', '/admin/common/skin/blue/skin.css')
    })
    $('#molv').click(function () {
        $('#layout-skin').attr('href', '/admin/common/skin/molv/skin.css')
    })
</script>

</body>

</body>
</html>