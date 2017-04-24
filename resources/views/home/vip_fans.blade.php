@extends('layouts.home.master')
@section('my-css')
    <style>
        .top{position:relative;}
        .topson{position:absolute;top:110px;left:355px;}
    </style>
    <link href="home/css/reset.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="home/css/demo.css"/>
    <style>
        .box span{display: inline-block;font-size: 15px;margin-top:0px;margin-right:3px;}
    </style>

    <style type="text/css">
        .demo{width:600px; margin:30px auto; color:#51555c}
        .demo h3{height:32px; line-height:32px; font-size:18px}
        .demo h3 span{float:right; font-size:32px; font-family:Georgia,serif; color:#ccc; overflow:hidden}
        .input{width:594px; height:58px; margin:5px 0 10px 0; padding:4px 2px; border:1px solid #aaa; font-size:12px; line-height:18px; overflow:hidden}
        .sub_btn{float:right; width:94px; height:28px;}
        .clear{clear:both}
        .saylist{margin:8px auto; padding:4px 0; border-bottom:1px dotted #d3d3d3}
        .saylist img{float:left; width:50px; margin:4px}
        .saytxt{float:right; width:530px; overflow:hidden}
        .saytxt p{line-height:18px}
        .saytxt p strong{margin-right:6px}
        .date{color:#999}
        .inact,.inact:hover{background:#f5f5f5; border:1px solid #eee; color:#aaa; cursor:auto;}
        #msg{color:#f30}
    </style>



@endsection

@section('my-js')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

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

@endsection

@section('vip')
    <div class="top" style="width: 980px;height: 300px;margin: 0 auto;">
        <img  src="/home/images/g1.jpg" style="margin-top:60px;">

        <div class="topson" style="width:270px;height:200px;margin: 0 auto;/*background-color: red;*/">
            <div style="width:100px;height:100px;margin-left:85px;">
                <img src="{{Auth::user()->avatar}}" style="width:100px;height:100px;border-radius: 50px;">
            </div>

            <div style="margin-left:35px;width:200px;text-align: center;margin-top:10px;margin-bottom:10px;">
                <p style="font-size:20px;color:white;">{{Auth::user()->name}}</p>
            </div>

            <div style="width:270px;text-align: center;margin-top:10px;margin-bottom:10px;margin:0 auto;">
                <a href="" style="color:white;">一句话介绍一下自己吧，让别人更了解你</a>
            </div>
        </div>
    </div>

    <div style="width:980px;margin:0 auto;margin-top:60px;">
        <div class="PCD_tab S_bg2">
            <div class="tab_wrap" style="width:60%">
                <table class="tb_tab" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td class="">
                            <a bpfilter="page" href="vip" class="tab_link">
                                <span class="S_txt1 t_link">我的主页</span>
                                <span class="ani_border"></span>
                            </a>
                        </td>
                        <td class=" ">
                            <a bpfilter="page" href="photo" node-type="nav_link" class="tab_link">
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
                    </tbody></table>
            </div>
        </div>
    </div>

    <div style="width:980px;margin:0 auto;margin-top:20px;background-color: #FCFCFC;">
        <div class="inner S_line2 clearfix">
            <ul class="tab_ul tab_ul_s W_fl">
                <li class="tab_li" style="margin-left: 20px;">
                    <span class="tab_item tab_cur S_line1 textcut">
                        <span class="W_f14 S_txt1" style="padding-top:20px;"><b>全部粉丝</b></span>
                        <em class="attach S_txt3" style="font-size: 15px;">
                             @if($count_fans)
                                {{$count_fans}}
                            @else
                                0
                            @endif
                        </em><em class="attach S_txt2" title=""></em></span>
                </li>
            </ul>
        </div>

        <div class="container" style="width:980px;">
            <div class="row" style="margin-bottom:10px;">
                @if(!$follows->isEmpty())
                @foreach($follows as $value)
                    @foreach($users as $value1)
                    @if($value->usersby_id==$value1->id)
                                <div class="col-md-4">
                                    <div>
                                        <div style="display: inline-block;float: left;">
                                            <img src="{{$value1->avatar}}" width="67px" height="108px">
                                        </div>

                                        <div style="float: left;display: inline-block;width:200px;height:20px;margin-left:10px;margin-top:5px;">
                                            {{$value1->name}}
                                        </div>

                                        <div style="float: left;display: inline-block;width:200px;height:30px;margin-left:10px;margin-top:5px;">
                                            <button class="btn btn-success"><b>+</b>&nbsp;关注</button>
                                        </div>

                                        <div style="float: left;display: inline-block;width:200px;height:30px;margin-left:10px;margin-top:5px;">
                                            <b>一句话介绍一下自己吧，让别人更了解你</b>
                                        </div>
                                    </div>
                                </div>
                        @else
                        @endif
                        @endforeach
                @endforeach
                    @else
                    <div style="width:675px;background-color: #F7FBFD;padding:10px;height: 400px;margin-right:100px;">
                        <img src="{{asset('home/images/zanwu.jpg')}}" alt="暂无图片">
                    </div>
                    @endif
            </div>
        </div>
    </div>
@endsection

