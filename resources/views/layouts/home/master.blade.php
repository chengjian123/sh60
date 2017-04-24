<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的首页 微博-随时随地发现新鲜事</title>


    <link rel="stylesheet" href="http://simg.sinajs.cn/miniblog/css/index/index.css?version=1.1.2.72" />
   {{-- <link rel="stylesheet" href="http://simg.sinajs.cn/miniblog/skin/skin_001/skin.css?version=1.1.2.72" />--}}
    @yield('my-css')
    @yield('my-js')

    <link putoff="style/css/module/combination/extra.css?version=4a6bc1b029b415f4" href="http://img.t.sinajs.cn/t6/style/css/module/base/frame.css?version=4a6bc1b029b415f4" type="text/css" rel="stylesheet" charset="utf-8" />	<link includes="style/css/module/global/WB_left_nav.css?version=4a6bc1b029b415f4|style/css/module/tab/comb_WB_tab_profile.css?version=4a6bc1b029b415f4|style/css/module/list/comb_WB_feed.css?version=4a6bc1b029b415f4|style/css/apps_PCD/reco/index_right.css?version=4a6bc1b029b415f4|style/css/module/global/WB_ad.css?version=4a6bc1b029b415f4|style/css/module/global/W_person_info.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_text_a.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_text_b.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_ut_a.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_ut_b.css?version=4a6bc1b029b415f4|style/css/module/list/comb_webim.css?version=4a6bc1b029b415f4|style/css/module/pagecard/PCD_pictext_b.css?version=4a6bc1b029b415f4|style/css/module/pagecard/PCD_pictext_g.css?version=4a6bc1b029b415f4|style/css/apps_PCD/event/PCD_event_redpacks.css?version=4a6bc1b029b415f4" href="http://img.t.sinajs.cn/t6/style/css/module/combination/home_A.css?version=4a6bc1b029b415f4" type="text/css" rel="stylesheet" charset="utf-8" />
    <link id="skin_style" href="http://img.t.sinajs.cn/t6/skin/skin048/skin.css?version=4a6bc1b029b415f4" type="text/css" rel="stylesheet" charset="utf-8" />
    <link rel="mask-icon" sizes="any" href="http://img.t.sinajs.cn/t6/style/images/apple/wbfont.svg" color="black" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link title="微博"  href="http://weibo.com/aj/static/opensearch.xml" type="application/opensearchdescription+xml"  rel="search"/>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            width:100%;
            height:100%;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #B4DAF1;
        }

       /* html{background-color: #C7CCDF;}*/
        /*body{background-color: #C7CCDF;}*/
        /*body{background-image: url(home/images/templatemo-bg-1.jpg);background-attachment: fixed;
            background-repeat: no-repeat;background-size:100% 100%;}*/
        .search{width:400px;}
        .navbar-form .form-control {
            display: inline-block;
            width: 400px;
            vertical-align: middle;
        }
        .navbar-default .navbar-nav > li > a:hover,
        .navbar-default .navbar-nav > li > a:focus {
            color: #FF8140;
            background-color: transparent;
        }
        .navbar-brand {
            float: left;
            height: 50px;
            padding: 2px 15px;
            font-size: 18px;
            line-height: 20px;
        }
        span{display: inline-block;font-size: 20px;margin-top:-5px;margin-right:3px;}
        .navbar-right li a{padding-left:20px;display: inline-block;}
        .navbar-right li:hover{color: #FF8140;}
        .span-search{font-size: 15px;margin-top:0px;padding: 0;}
        .main{padding-top:65px;background-color: #97A9C6;padding-bottom: 30px;}
        .main-left a{text-align: center;font-size: 18px;color: white;}
        .main-left li a span{color:white;font-size: 18px;margin-right: 10px;}
        .fensi ul li{float: left;}
        .list-group-item1{background-color:#91A9C9;border:none;font-size:10px;}
        .lv1{margin-left:10px;}
        .list-group1 a:hover{color:#FF8140;}
    </style>

</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="/home/images/logo.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <form class="navbar-form navbar-left">
                <div class="form-group search">
                    <input type="text" class="form-control search-input1" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search span-search" aria-hidden="true"></span>
                </button>
            </form>
            <ul class="nav navbar-nav navbar-right">

                <li>
                    {{--<span class="glyphicon glyphicon-home" aria-hidden="true"></span>--}}
                    <a href="#">首页</a>
                </li>
                <li>

                    <a href="#">视频</a>
                </li>
                <li>

                    <a href="#">发现</a>
                </li>
                <li>

                    <a href="#">游戏</a>
                </li>
                @if(Auth::check())

                    <li><a href=""><span class="glyphicon glyphicon-user" aria-hidden="true"></span>{{Auth::user()->name}}</a></li>
                    <li><a href="loginout">退出</a></li>
                    <li><a href="#">写微博</a></li>
                @else
                    <li>
                        <a href="/home/register">注册</a>
                    </li>

                    <li>
                       <a href="/home/login" id="modaltrigger"  class="flatbtn">登录</a>
                    </li>
                @endif

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


@section('vip')

<div class="container main">
    <div class='row'>

        @section('one')
         <div class="col-md-2" style="padding-right:0px;padding-left:0px;position:fixed;">

             <ul class="nav nav-pills nav-stacked main-left" style="background-color: #97A9C6;">
                 <li>
                     <a href="#" class="list-group-item list-group-item1">
                         <span class="glyphicon glyphicon-fire first" style="color:white;"></span>
                         热门
                     </a>
                 </li>

                 <li class="lv1">
                     <a href="#" class="list-group-item list-group-item1">
                         <span class="ico_block"><em class="W_ficon ficon_dot S_ficon W_f12">D</em></span>
                         明星
                     </a>
                 </li>

                 <li class="lv1">
                     <a href="#" class="list-group-item list-group-item1">
                         <span class="ico_block"><em class="W_ficon ficon_dot S_ficon W_f12">D</em></span>
                         搞笑
                     </a>
                 </li>

                 <li class="lv1">
                     <a href="#" class="list-group-item list-group-item1"><span class="ico_block"><em class="W_ficon ficon_dot S_ficon W_f12">D</em></span>
                         社会
                     </a>
                 </li>

                 <li>
                     <a href="#" class="list-group-item list-group-item1">
                         <span class="glyphicon glyphicon-facetime-video" style="color:white;"></span>视频</a>
                 </li>
                 <li>
                     <a href="#" class="list-group-item list-group-item1">
                         <span class="glyphicon glyphicon-flash" style="color:white;padding-left:40px;"></span>
                         头条
                         <span class="W_new_count" style="font-size: 10px;">HOT</span>
                     </a>

                 </li>

                 <li class="lv1">
                     <a href="#" class="list-group-item list-group-item1"><span class="ico_block"><em class="W_ficon ficon_dot S_ficon W_f12">D</em></span>
                         情感
                     </a>
                 </li>

                 <li class="lv1">
                     <a href="#" class="list-group-item list-group-item1"><span class="ico_block"><em class="W_ficon ficon_dot S_ficon W_f12">D</em></span>
                         时尚
                     </a>
                 </li>

                 <li class="lv1">
                     <a href="#" class="list-group-item list-group-item1"><span class="ico_block"><em class="W_ficon ficon_dot S_ficon W_f12">D</em></span>
                         军事
                     </a>
                 </li>

                 <li>
                     <a href="#" class="list-group-item list-group-item1">
                         <span class="glyphicon glyphicon-tower" style="color:white;padding-left:40px;"></span>
                         榜单
                         <em class="W_new_count W_new_count2" style="font-size: 10px;">NEW</em>
                     </a>
                 </li>
             </ul>

         </div>
        @show


        @section('main')
         <div class="col-md-7" style="padding-left:0px;background-color: blue;height:100px;margin-left:225px;width:650px;">
             <div class="m_wrap">
                 <ul>
                     <li>1111</li>
                     <li>2222</li>
                     <li>3333</li>
                     <li>4444</li>
                 </ul>
             </div>
         </div>
        @show

        @section('my-weibo')
         <div class="col-md-3" style="/*background-color: white;*/width:272.5px;margin-left:10px;margin-right:10px;padding:0;">
            <div style="background-color: white;">
                <div class="row">
                    <div class="col-md-12">
                        <h3><center>账号登录</center></h3>
                    </div>
                </div>


                <form>
                    <div class="row">
                        <div class="form-group">
                            <div class="input-group col-md-10  col-sm-offset-1">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-user login-user" aria-hidden="true"></span>
                                </div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="邮箱/手机号">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="input-group col-md-10  col-sm-offset-1">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock login-user" aria-hidden="true"></span>
                                </div>
                                <input type="password" class="form-control" id="exampleInputAmount" placeholder="密码">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5" style="margin-left: 10px;">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">记住我
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="checkbox2">
                                <label>
                                    <a href=""  style="line-height: 40px;">忘记密码</a>
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-offset-1 col-md-10 input-group">
                                <input type="submit" class="btn btn-warning" value="登录" style="width: 243px;">
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">

                    <div class="col-sm-10" style="margin-left: 10px;color:#F76F27;">
                        <div>
                            <label>
                                还没有微博?<a href="">立即注册</a>
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-10" style="margin-left: 10px;color:#F76F27;margin-bottom:10px;">
                        <div>
                            其他登录:<a href=""></a>
                        </div>
                    </div>
                </div>
           </div>

             <div class="row" style="margin-top:10px;">
                    <div style="text-align: center;">
                        <img src="/home/images/app.png" width="272.5px;">
                    </div>
             </div>

                <div class="row" style="margin-top:10px;">
                   <div style="text-align: center;">
                       <img src="/home/images/app2.png" width="272.5px;">
                   </div>
                </div>

                <div class="row">
                    <div class="list-group list-group1" style="width: 272.5px;margin-left:16px;margin-top:10px;">
                        <a href="#" class="list-group-item">
                            <b>热门话题</b>
                        </a>
                        <a href="#" class="list-group-item">#白百何出轨#</a>
                        <a href="#" class="list-group-item">#运动范#</a>
                        <a href="#" class="list-group-item">#我的照片会开花#</a>
                        <a href="#" class="list-group-item">#张杰献唱择天记#</a>
                    </div>
                </div>

             <div class="row" style="margin-top:-10px;">
                 <div style="text-align: center;">
                     <img src="/home/images/app3.png" width="272.5px;">
                 </div>
             </div>

             <div class="row" style="margin-top:-10px;">

             </div>

         </div>
         @show

    </div>
</div>

@show
<script src="http://www.jq22.com/js/jq.js"></script>

@yield('aaa')
@yield('endscript')

</body>

</html>