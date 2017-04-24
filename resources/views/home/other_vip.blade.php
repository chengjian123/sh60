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
            @foreach($users as $value1)
            <div style="width:100px;height:100px;margin-left:85px;">
                <img src="{{$value1->avatar}}" style="width:100px;height:100px;border-radius: 50px;">
            </div>

            <div style="margin-left:35px;width:200px;text-align: center;margin-top:10px;margin-bottom:10px;">
                <p style="font-size:20px;color:white;">{{$value1->name}}</p>
            </div>

            <div style="width:270px;text-align: center;margin-top:10px;margin-bottom:10px;margin:0 auto;">
                <a href="" style="color:white;">一句话介绍一下自己吧，让别人更了解你</a>
            </div>

             @if($value1->id==Auth::user()->id)

                 @else
             <div style="margin-top: 20px;">
                 @if(!$follow->isEmpty())
                 @foreach($follow as $value_follow)
                         @if($value_follow->usersby_id==Auth::user()->id)
                             <form action="{{url('home/nozhu'.'/'.$value_follow->usersby_id)}}">
                                 <input type="hidden" value="{{$value1->id}}" name="users_id">
                                 <input type="submit"  class="btn btn-warning" value="已关注(取消关注)">
                             </form>
                         @else
                         <form action="{{url('home/guanzhu'.'/'.$value1->id)}}">
                             <input type="hidden" value="{{Auth::user()->id}}" name="usersby_id">
                             <input type="submit" class="btn btn-info" value="+ 关注">
                         </form>
                         @endif
                @endforeach
                @else
                    {{-- @foreach($follow as $value_follow)
                         @if($value_follow->usersby_id==Auth::user()->id)
                             <form action="{{url('home/nozhu'.'/'.$value_follow->usersby_id)}}">
                                 <input type="hidden" value="{{$value1->id}}" name="users_id">
                                 <input type="submit"  class="btn btn-warning" value="已关注(取消关注)">
                             </form>
                         @else--}}
                             <form action="{{url('home/guanzhu'.'/'.$value1->id)}}">
                                 <input type="hidden" value="{{Auth::user()->id}}" name="usersby_id">
                                 <input type="submit" class="btn btn-info" value="+ 关注">
                             </form>
                   {{--  @endforeach--}}
                 @endif
             </div>
                @endif
            @endforeach
        </div>
    </div>

    <div style="width:980px;margin:0 auto;margin-top:60px;">
        <div class="PCD_tab S_bg2">
            <div class="tab_wrap" style="width:60%">
                <table class="tb_tab" cellpadding="0" cellspacing="0">
                    @foreach($users as $value1)
                    @if(Auth::user()->id==$value1->id)
                    <tbody><tr>
                        <td class="">
                            <a bpfilter="page" href="{{url('home/vip')}}" class="tab_link">
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

    <div style="width:980px;margin:0 auto;margin-top:20px;">
        <div style="width:330px;float:left;">
            <div style="width:330px;height:60px;background-color: white;padding:10px 0;">
                <div style="width:110px;float: left;height:60px;text-align: center;">
                    <a bpfilter="page_frame" class="t_link S_txt1" href="">
                        <strong style="width:110px;height:20px;display: inline-block;" class="W_f18">
                            @if($count_fans)
                                {{$count_fans}}
                            @else
                                0
                            @endif
                        </strong>
                        <span style="font-size:12px;" class="S_txt2">关注</span>
                    </a>
                </div>

                <div style="width:110px;float: left;height:60px;text-align: center;">
                    <a bpfilter="page_frame" class="t_link S_txt1" href=""><strong style="width:110px;height:20px;display: inline-block;" class="W_f18">157</strong><span style="font-size:12px;" class="S_txt2">粉丝</span></a>
                </div>

                <div style="width:110px;float: left;height:60px;text-align: center;">
                    <a bpfilter="page_frame" class="t_link S_txt1" href=""><strong style="width:110px;height:20px;display: inline-block;" class="W_f18">
                           @if($count_weibo)
                                {{$count_weibo}}
                            @else
                                0
                            @endif
                        </strong><span style="font-size:12px;" class="S_txt2">微博</span></a>
                </div>
            </div>
        </div>

        <div style="width:626px;margin-left:20px;float:left;margin-bottom:30px;">
            @foreach($say as $v)
               {{-- @if(Auth::user()->id==$v->users_id)--}}
                    <div style="width: 630px;margin: 0 auto;border:1px solid #CCC;margin: 0 auto;margin-bottom: 10px;margin-top:0px;background-color: white;border-radius: 3px;">
                        <div style="width:550px;margin:0 auto;margin-top: 10px;">
                            <div style="float:left;">
                                <img src="" alt="头像" width="50px;" height="50px">
                            </div>

                            <div style="float:left;width:400px;">
                                <div style="height:25px;margin-left: 10px;"></div>
                                <div style="height:25px;font-size:15px;margin-left: 10px;">{{$v->addtime}}</div>
                            </div>
                            @if(Auth::user()->id==$v->users_id)
                           <div style="float:right;width:50px;">
                                <a id="del-1" style="color:#F0AD4E;" href="{{url('/home/del-2'.'/'.$v->id)}}">删除</a>
                            </div>
                            @else
                            @endif
                        </div>

                        <div style="width:450px;margin:0 auto;margin-top:70px;margin-left:95px;">
                            {{$v->content}}
                        </div>
                        <ul class="WB_row_line WB_row_r4 clearfix S_line2">
                            <li>
                                <a class="S_txt2">
                            <span class="pos">
                                <span class="line S_line1" node-type="favorite_btn_text">
                                    <span style="font-size:15px;"><em class="W_ficon ficon_favorite S_ficon">û</em><em>收藏</em>
                                    </span>
                                </span>
                            </span>
                                </a>
                            </li>

                            <li>
                                <a class="S_txt2">
                            <span class="pos">
                                <span class="line S_line1" node-type="forward_btn_text">
                                    <span   style="font-size:15px;"><em class="W_ficon ficon_forward S_ficon"></em><em>转发</em></span>
                                </span>
                            </span>
                                </a>
                            </li>
                            <li class="pl">
                                <a class="S_txt2" suda-data="key=smart_feed&amp;value=time_sort_comm:4097532940862127" href="javascript:void(0);" action-type="fl_comment" action-data="ouid=3264426464&amp;location=home">
                            <span class="pos"><span class="line S_line1" node-type="comment_btn_text">
                                    <span  style="font-size:15px;"><em class="W_ficon ficon_repeat S_ficon"></em><em>评论</em>
                                    </span>
                                </span>
                            </span>
                                </a>
                                <span class="arrow" style="display: none;" node-type="cmtarrow">
                            <span class="W_arrow_bor W_arrow_bor_t">
                                <i class="S_line1"></i><em class="S_bg1_br"></em>
                            </span>
                        </span>
                            </li>
                            <li>
                                <a id="zan" href="javascript:void(0);" class="S_txt2" action-type="fl_like" action-data="version=mini&amp;qid=heart&amp;mid=4097532940862127&amp;like_src=1" title="赞">
                            <span class="pos">
                                <span class="line S_line1">
                                  <span   style="font-size:15px;" node-type="like_status" class=""><em id="zn" class="W_ficon ficon_praised S_txt2">ñ</em><em>赞</em>
                               </span>
                             </span>
                           </span>
                                </a>
                            </li>
                        </ul>

                        <div class="ping" class="demo" style="background-color: white;width: 626px;margin: 0 auto;border-radius: 3px;display: none;">
                            <form action="Ping-vip" method="post">
                                {{csrf_field()}}
                                <textarea style="width: 550px;margin: 0 auto;margin-left:40px;" name="commit_content" id="saytxt" class="input" tabindex="1" rows="2" cols="40"></textarea>
                                <div style="background-color: white;padding: 10px 0;border-radius: 3px;">
                                    <p>
                                        <input class="btn btn-warning" style="float:right;margin-right:40px;display: inline-block; " type="submit" value="评论">
                                        <span id="msg"></span>
                                        <input type="hidden" value="{{date('Y-m-d H:i:s',time())}}" name="commit_time">
                                        <input id="zid" type="hidden" value="{{$v->id}}" name="say_id">
                                    </p>
                                </div>
                            </form>

                            @foreach($commit as $value)
                                @if($value->say_id==$v->id)
                                    <div style="width: 626px;margin: 0 auto;margin-top:10px;margin-bottom: 10px;background-color: white;border-radius: 3px;overflow: hidden;">
                                        <div style="width:620px;margin:0 auto;margin-top: 10px;">
                                            <div style="float:left;margin-left:50px;">
                                                <img src="" alt="头像" width="50px;" height="50px">
                                            </div>

                                            <div style="float:left;width:400px;">
                                                <div style="height:25px;margin-left: 10px;"></div>
                                                <div style="height:25px;font-size:15px;margin-left: 10px;">{{$value->commit_time}}</div>
                                            </div>
                                        </div>

                                        <div style="width:500px;margin:0 auto;margin-top:80px;background-color: #EAEAEC;">
                                            {{$value->commit_content}}
                                        </div>
                                        <div style="width:630px;float: right;margin-right: 60px;">
                                            <ul class="WB_row_line WB_row_r4 clearfix S_line2">
                                                @if(Auth::user()->id==$v->users_id)
                                              <li style="float: right;">
                                                    <a href="{{url('/home/del-2'.'/'.$value->id)}}" class="S_txt2" action-type="fl_like" action-data="version=mini&amp;qid=heart&amp;mid=4097532940862127&amp;like_src=1" title="赞">
                                                            <span class="pos">
                                                                <span class="line S_line1" style="border-left-style:none;">
                                                                    <span   style="font-size:15px;" node-type="like_status" class=""><em>删除</em>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                    </a>
                                                </li>
                                                @else
                                                @endif
                                                <li class="pl" style="float: right;">
                                                    <a class="S_txt2" suda-data="key=smart_feed&amp;value=time_sort_comm:4097532940862127" href="javascript:void(0);" action-type="fl_comment" action-data="ouid=3264426464&amp;location=home">
                                                                <span class="pos"><span class="line S_line1" node-type="comment_btn_text" style="border-left-style:none;">
                                                                        <span  style="font-size:15px;"><em class="W_ficon ficon_repeat S_ficon"></em><em>回复</em>
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                    </a>
                                                    <span class="arrow" style="display: none;" node-type="cmtarrow">
                                                            <span class="W_arrow_bor W_arrow_bor_t">
                                                                <i class="S_line1"></i><em class="S_bg1_br"></em>
                                                            </span>
                                                        </span>
                                                </li>
                                            </ul>

                                            <div class="ping" class="demo" style="margin:0 auto;background-color: white;width: 400px;border-radius: 3px;display: none;">
                                                <form action="{{url('home/hui')}}" method="post">
                                                    {{csrf_field()}}
                                                    <textarea style="width: 500px;height:20px;margin: 0 auto;margin-left:10px;" name="hui_content" id="saytxt" class="input" tabindex="1" rows="2" cols="40"></textarea>
                                                    <div style="background-color: white;padding: 10px 0;border-radius: 3px;width:500px;">
                                                        <p>
                                                            <input class="btn btn-warning" style="float:right;margin-right:10px;display: inline-block; " type="submit" value="回复">
                                                            <span id="msg"></span>
                                                            <input type="hidden" value="{{date('Y-m-d H:i:s',time())}}" name="addtime">
                                                            <input id="zid" type="hidden" value="{{$v->id}}" name="says_id">
                                                            <input id="zid" type="hidden" value="{{$value->id}}" name="commit_id">
                                                        </p>
                                                    </div>
                                                </form>
                                                @foreach($hui as $v1)
                                                    @if($v1->commit_id==$value->id)
                                                        <div style="width:620px;margin:0 auto;margin-top: 10px;">
                                                            <div style="float:left;">
                                                                <img src="" alt="头像" width="50px;" height="50px">
                                                            </div>

                                                            <div style="float:left;width:400px;">
                                                                <div style="height:25px;margin-left: 10px;"></div>
                                                                <div style="height:25px;font-size:15px;margin-left: 10px;">{{$v1->addtime}}</div>
                                                            </div>
                                                        </div>
                                                        <div style="width:500px;margin:0 auto;margin-top:80px;background-color: #EAEAEC;">
                                                            {{$v1->hui_content}}
                                                        </div>
                                                    @else
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                @else
                                @endif
                            @endforeach
                        </div>
                    </div>
            @endforeach
        </div>
@endsection