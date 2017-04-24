<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @yield('my-js')
    @yield('my-css')

    <link putoff="style/css/module/combination/extra.css?version=4a6bc1b029b415f4" href="http://img.t.sinajs.cn/t6/style/css/module/base/frame.css?version=4a6bc1b029b415f4" type="text/css" rel="stylesheet" charset="utf-8" />	<link includes="style/css/module/global/WB_left_nav.css?version=4a6bc1b029b415f4|style/css/module/tab/comb_WB_tab_profile.css?version=4a6bc1b029b415f4|style/css/module/list/comb_WB_feed.css?version=4a6bc1b029b415f4|style/css/apps_PCD/reco/index_right.css?version=4a6bc1b029b415f4|style/css/module/global/WB_ad.css?version=4a6bc1b029b415f4|style/css/module/global/W_person_info.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_text_a.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_text_b.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_ut_a.css?version=4a6bc1b029b415f4|style/css/module/global/WB_rm_ut_b.css?version=4a6bc1b029b415f4|style/css/module/list/comb_webim.css?version=4a6bc1b029b415f4|style/css/module/pagecard/PCD_pictext_b.css?version=4a6bc1b029b415f4|style/css/module/pagecard/PCD_pictext_g.css?version=4a6bc1b029b415f4|style/css/apps_PCD/event/PCD_event_redpacks.css?version=4a6bc1b029b415f4" href="http://img.t.sinajs.cn/t6/style/css/module/combination/home_A.css?version=4a6bc1b029b415f4" type="text/css" rel="stylesheet" charset="utf-8" />
    <link id="skin_style" href="http://img.t.sinajs.cn/t6/skin/skin048/skin.css?version=4a6bc1b029b415f4" type="text/css" rel="stylesheet" charset="utf-8" />
    <link rel="mask-icon" sizes="any" href="http://img.t.sinajs.cn/t6/style/images/apple/wbfont.svg" color="black" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link title="微博"  href="http://weibo.com/aj/static/opensearch.xml" type="application/opensearchdescription+xml"  rel="search"/>
    <link href="home/css/weibo.css" type="text/css" rel="stylesheet">


    <link href="/home/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='/home/js/jquery-1.9.1.min.js'></script>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <script>
        $(function(){
            $('.pl').click(function(){
                $(this).parent().next('div').slideToggle('slow',function () {

                });
            });
        });


    </script>

    <script>
        $(function(){
                $('#saytxt').bind("blur focus keydown keypress keyup", function(){
                    recount();
                });
                $("#myform").submit(function(){
                    //var submitData = $(this).serialize();
                    var saytxt = $("#saytxt").val();
                    if(saytxt==""){
                        $("#msg").show().html("你总得说点什么吧.").fadeOut(1200);;
                        return false;
                    }
                    $('.counter').html('<img style="padding:8px 12px" src="images/load.gif" alt="正在处理..." />');
                    $.ajax({
                        type: "POST",
                        url: "submit.php",
                        //data: submitData,
                        data:"saytxt="+saytxt,
                        dataType: "html",
                        success: function(msg){
                            if(parseInt(msg)!=0){
                                $('#saywrap').prepend(msg);
                                $('#saytxt').val('');
                                recount();
                            }
                        }
                    });
                    return false;
                });
            }
        );

        function recount(){
            var maxlen=140;

            var current = maxlen-$('#saytxt').val().length;
            $('.counter').html(current);

            if(current<1 || current>maxlen){
                $('.counter').css('color','#D40D12');
                $('input.sub_btn').attr('disabled','disabled');
            }
            else
                $('input.sub_btn').removeAttr('disabled');

            if(current<10)
                $('.counter').css('color','#D40D12');

            else if(current<20)
                $('.counter').css('color','#5C0002');

            else
                $('.counter').css('color','#cccccc');

        }

    </script>

    <style>
        .top{position:relative;}
        .topson{position:absolute;top:110px;left:355px;}
        body {
            width:100%;
            height:100%;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #B4DAF1;
        }

        .navbar-brand {
            float: left;
            height: 50px;
            padding: 4px 15px;
            font-size: 18px;
            line-height: 20px;
        }
    </style>


    <style>
        /*弹出窗口*/
        .Popup{position: fixed;top: 0;right: 0; bottom: 0; left: 0;z-index: 1050;opacity: 1;color: #333;display: none;}

        .PopupShow{display: block;}
        .Popup-dialog{width: 600px;margin: 0 auto;position: fixed;top: -1000px;left: 0;right: 0;
            /*left: 50%;或者这个加下面的margin也可以居中*/
            /*margin-left: -300px;*/
        }

        .Popup-content{background-color:#fff;border-radius: 6px;border: 1px solid rgba(0,0,0,.2);box-shadow: 0 5px 15px rgba(0,0,0,.5);}
        .Popup-header{padding: 15px;border-bottom: 1px solid #e5e5e5;}
        .Popup-body{padding: 15px;}
        .Popup-footer{padding: 15px;border-top: 1px solid #e5e5e5;text-align: right;}
        .Popup-backdrop{position: fixed;  top: 0;  right: 0;  bottom: 0;  left: 0;  z-index: 1040;  background-color: #000;opacity: .5;display: none;}
        .Popup_fade{display: none;}
        .Popup_in{opacity: 1;display: block;}
        .Popup_in2{opacity: .5;display: block;}
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
                    <li><a href="{{url('home/loginout')}}">退出</a></li>
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

     <div class="top" style="width: 980px;height: 300px;margin: 0 auto;">
         <img  src="/home/images/g1.jpg" style="margin-top:60px;">
         @foreach($users as $value)
         <div class="topson" style="width:270px;height:200px;margin: 0 auto;/*background-color: red;*/">
             <div style="width:100px;height:100px;margin-left:85px;">
                 <img src="{{$value->avatar}}" style="width:100px;height:100px;border-radius: 50px;">
             </div>

             <div style="margin-left:35px;width:200px;text-align: center;margin-top:10px;margin-bottom:10px;">
                 <p style="font-size:20px;color:white;">{{$value->name}}</p>
             </div>

             <div style="width:270px;text-align: center;margin-top:10px;margin-bottom:10px;margin:0 auto;">
                 <a href="" style="color:white;">一句话介绍一下自己吧，让别人更了解你</a>
             </div>
             @if($value->id==Auth::user()->id)
             @else
             <div style="margin-top: 20px;">
                 <a href="" class="btn btn-info"><b>+</b>&nbsp;关注</a>
             </div>
             @endif
         </div>
             @endforeach
     </div>

     <div style="width:980px;margin:0 auto;margin-top:60px;">
         <div class="PCD_tab S_bg2">
             <div class="tab_wrap" style="width:60%">
                 <table class="tb_tab" cellpadding="0" cellspacing="0">
                     @foreach($users as $value1)
                         @if(Auth::user()->id==$value1->id)
                             <tbody><tr>
                                 <td class="">
                                     <a bpfilter="page" href="vip" class="tab_link">
                                         <span class="S_txt1 t_link">我的主页</span>
                                         <span class="ani_border"></span>
                                     </a>
                                 </td>
                                 <td class=" ">
                                     <a bpfilter="page" href="{{url('home/photo')}}" node-type="nav_link" class="tab_link">
                                         <span class="S_txt1 t_link">我的相册</span>
                                         <span class="ani_border"></span>
                                     </a>
                                 </td>
                                 <td class=" ">
                                     <a bpfilter="page" href="vip" node-type="nav_link" class="tab_link">
                                         <span class="S_txt1 t_link">管理中心</span>
                                         <span class="ani_border"></span>
                                     </a>
                                 </td>
                             </tr>
                             </tbody>

                         @else
                             <tbody><tr>
                                 <td class="">
                                     <a bpfilter="page" href="{{url('home/other_per'.'/'.$value1->id)}}" class="tab_link">
                                         <span class="S_txt1 t_link">他的主页</span>
                                         <span class="ani_border"></span>
                                     </a>
                                 </td>
                                 <td class=" ">
                                     <a bpfilter="page" href="{{url('home/photo'.'/'.$value1->id)}}" node-type="nav_link" class="tab_link">
                                         <span class="S_txt1 t_link">他的相册</span>
                                         <span class="ani_border"></span>
                                     </a>
                                 </td>
                             </tr>
                             </tbody>
                         @endif
                     @endforeach
                 </table>
             </div>
         </div>
     </div>

     <div style="width:980px;margin:0 auto;margin-top:0px;margin-bottom:30px;background-color: white;">
         <div style="width:980px;background-color: #F7FBFD;padding:10px;height: 40px;">
             <div style="float:left;display: inline-block;">
                 相册管理
             </div>
             @foreach($users as $value1)
                 @if(Auth::user()->id==$value1->id)
             <div style="float:right;display: inline-block;">
                 <a id="popup" class="S_txt1" href="javascript:void(0);" action-type="widget_publish" action-data="triggerClick=%5Baction-type%3Dmultiimage%5D" suda-uatrack="key=v6_profilealbum&amp;value=upload_photo">
                     <em class="W_ficon ficon_image">p
                     </em>创建相册
                 </a>
             </div>
                 @else
                 @endif
                 @endforeach
         </div>

         @section('shang')
         <div style="width:980px;background-color: #F7FBFD;padding:10px;">
             <div class="container" style="width:960px;background-color: #F7FBFD;">
                 @if($album->isEmpty())

                         <div style="width:920px;background-color: #F7FBFD;padding:0px;height: 400px;">
                             <div class="container" style="text-align: center;width:955px;margin:0 auto;margin-top:30px;">
                                 <img src="/home/images/zanwu.jpg" alt="暂无图片">
                             </div>
                         </div>

                 @else
                 @foreach($album as $v)
                         <div class="row" style="width:960px;border-bottom:1px solid #ccc;padding-bottom:10px;padding-top:10px;">
                         <div class="col-md-12">
                             <div class="row">
                                 <div class="col-md-4">
                                     <div style="width:100px;height: 100px;float:left;">
                                         <a href="{{url('home/photo-1'.'/'.$v->id)}}">
                                             <img src="/home/images/g3.jpg" width="100px" height="100px">
                                         </a>
                                     </div>
                                     <div style="display: inline-block;width:100px;height:50px;float:left;text-align: center;line-height: 50px;">
                                         {{$v->album_name}}
                                     </div>
                                     <div style="display: inline-block;width:150px;height:50px;float:left;text-align: center;line-height: 50px;">
                                         {{$v->addtime}}
                                     </div>
                                 </div>

                                 @foreach($users as $value1)
                                     @if(Auth::user()->id==$value1->id)
                                 <div class="col-md-4" style="margin-top:50px;margin-left:230px;">
                                     <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                         上传图片
                                     </button>
                                 </div>
                                     @else
                                     @endif
                                 @endforeach

                                 <!-- 弹出上传图片 -->
                                 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                     <div class="modal-dialog" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                 <h4 class="modal-title" id="myModalLabel">上传图片</h4>
                                             </div>
                                             <form action="{{url('home/upphoto')}}" method="post" enctype="multipart/form-data">
                                                 {{csrf_field()}}
                                                 <div class="modal-body">
                                                     <input type="file" name="photo_name">
                                                     <input type="hidden" value="{{date('Y-m-d H:i:s',time())}}" name="addtime">
                                                     <input type="hidden" value="{{$v->id}}" name="album_id">
                                                 </div>
                                                 <div class="modal-footer">
                                                     <input type="submit" class="btn btn-primary" value="确认上传">
                                                 </div>
                                             </form>

                                         </div>
                                     </div>
                                 </div>
                                 <!--弹出上传图片结束-->
                                 @foreach($users as $value1)
                                     @if(Auth::user()->id==$value1->id)
                                 <div class="col-md-4" style="margin-top:50px;float:right;width:83px;">
                                     <a style="float: right;" href="{{url('home/del_album'.'/'.$v->id)}}" class="btn btn-warning">删除相册</a>
                                 </div>
                                     @else
                                     @endif
                                 @endforeach
                             </div>
                         </div>
                     </div>
                 @endforeach
                 @endif

             </div>
         </div>
         @show
     </div>


     <div class="Popup " >
         <div class="Popup-dialog " >
             <div class="Popup-content">
                 <div class="Popup-header">
                     <button class="close">x</button>
                     <h4>创建相册</h4>
                 </div>
                 <form action="" method="post">
                     {{csrf_field()}}
                     <input type="hidden" value="{{date('Y-m-d H:i:s',time())}}" name="addtime">
                     <div class="Popup-body">
                         相册名称:<input type="text" name="album_name">
                     </div>
                     <div class="Popup-footer">
                         <input type="submit" name="button" value="确认创建" class="btn btn-primary" >
                     </div>
                 </form>

             </div>
         </div>
     </div>

  <script type="text/javascript">
         function popup(){
             $(".Popup").removeClass("Popup_in").addClass("Popup_fade");
             $(".Popup-backdrop").removeClass("Popup_in2").removeClass("Popup_fade").addClass("Popup_fade");
         }

         $(".Popup-header").on("click",".close",function(){//这个是关闭弹出框
             $(".Popup-dialog").animate({top:-1000});
             setTimeout("popup()",300)
         });
         $("#popup").click(function(){//点击按钮弹出
             $(".Popup-backdrop").toggleClass("Popup_in2");
             $(".Popup").toggleClass("Popup_in");
             $(".Popup-dialog").animate({top:30});
         });
  </script>
     @yield('my-js2')
</body>
</html>