@extends('layouts.home.master')
@section('my-css')
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

@section('my-weibo')
    {{--@if(Auth::check())--}}
        <div class="col-md-3" style="/*background-color: white;*/width:272.5px;margin-left:10px;margin-right:10px;padding:0;">
            <div style="background-color: white;padding-bottom:10px;">
                <div class="row">
                    <div>
                        <img src="/home/images/icon.png" width="272.5px;" style="margin-left:15px;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style="text-align: center;padding: 5px 0;padding-left:7.5px;">
                        <a>{{Auth::user()->name}}</a> <i class="W_icon icon_member_dis"></i><span node-type="levelBox" levelup="0" action-data="level=15" class="W_icon_level icon_level_c3" style="width:30px;"><span class="txt_out"><span class="txt_in"><span node-type="levelNum" title="微博等级15 升级有好礼">Lv.15</span></span></span></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 fensi" style="margin-left: 5px;">
                        <ul class="user_atten clearfix W_f18">
                            <li class="S_line1" style="margin-left:40px;">
                                <a bpfilter="page_frame" href="{{url('home/vip_follow')}}" class="S_txt1">
                                    <strong node-type="follow">
                                        @if($count_fans)
                                            {{$count_fans}}
                                        @else
                                            0
                                        @endif
                                    </strong>
                                    <span class="S_txt2" style="padding-top:5px;">关注</span>
                                </a>
                            </li>
                            <li class="S_line1">
                                <a bpfilter="page_frame" href="{{url('home/vip_fans')}}" class="S_txt1">
                                    <strong node-type="fans">
                                        @if($count_fans1)
                                            {{$count_fans1}}
                                        @else
                                            0
                                        @endif
                                    </strong>
                                    <span class="S_txt2" style="padding-top:5px;">粉丝</span>
                                </a>
                            </li>
                            <li class="S_line1">
                                <a bpfilter="page_frame" href="{{url('home/vip')}}" class="S_txt1">
                                    <strong node-type="weibo">
                                            @if($count_weibo)
                                               {{$count_weibo}}
                                            @else
                                              0
                                            @endif
                                    </strong>
                                    <span class="S_txt2" style="padding-top:5px;">微博</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row sb">
                <div class="list-group list-group1" style="width: 272.5px;margin-left:16px;margin-top:20px;">
                    <a href="#" class="list-group-item" style="color:#FE7E00;">
                        <b>微博电影想看榜</b>
                    </a>
                    <a href="#" class="list-group-item"><i class="icon_num_red">1</i> 速度与激情8</a>
                    <a href="#" class="list-group-item"><i class="icon_num_red">2</i> 傲娇与偏见</a>
                    <a href="#" class="list-group-item"><i class="icon_num_red">3</i> 春娇救志明</a>
                </div>
            </div>


            <div class="row">
                <div class="list-group list-group1" style="width: 272.5px;margin-left:16px;">
                    <a href="#" class="list-group-item active">
                        热门话题
                    </a>
                    <a href="#" class="list-group-item">#白百何出轨#</a>
                    <a href="#" class="list-group-item">#运动范#</a>
                    <a href="#" class="list-group-item">#我的照片会开花#</a>
                    <a href="#" class="list-group-item">#张杰献唱择天记#</a>
                </div>
            </div>

        </div>
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

  {{--  <script>
        $('.status').click(function(){
            var $id = $('#Sayid').val();
            $.ajax({
                type:'get',
                url:'/home/zan'+'/'+$id,
            });
        });
    </script>--}}

   {{-- <script>
        $(function(){
            $("#praise").click(function(){
                var praise_img = $("#praise-img");
                var text_box = $("#add-num");
                var praise_txt = $("#praise-txt");
                var num=parseInt(praise_txt.text());
                if(praise_img.attr("src") == ("{{asset('home/images/upvote.png')}}")){
                    $(this).html("<img src='{{asset('home/images/downvote.png')}}' id='praise-img' class='animation' />");
                    praise_txt.removeClass("hover");
                    text_box.show().html("<em class='add-animation'>-1</em>");
                    $(".add-animation").removeClass("hover");
                    num -=1;
                    praise_txt.text(num)
                }else{
                    $(this).html("<img src='{{asset('home/images/upvote.png')}}' id='praise-img' class='animation' />");
                    praise_txt.addClass("hover");
                    text_box.show().html("<em class='add-animation'>+1</em>");
                    $(".add-animation").addClass("hover");
                    num +=1;
                    praise_txt.text(num)
                }
            });
        })
    </script>--}}

    <style>
        #praise {
            width:20px;height:20px;
        }
        #praise img {
            width:20px;height:20px;cursor:pointer;
        }
        #praise-txt{width:20px;float:left}
        #yj{width:181px;height:38px;float:left;list-style: none;}
    </style>
    <link rel="stylesheet" href="{{asset('home/css/upvote.css')}}">
    <link rel="stylesheet" href="{{asset('home/dist/css/bootstrap.css')}}">
    <script src="{{asset('home/dist/js/jquery-2.1.4.min.js')}}"></script>

@endsection

@section('one')
   <div class="col-md-2" style="padding-right:0px;padding-left:0px;position:fixed;">
    <div class="WB_main_l box" fixed-box="true" style="width: 150px;">
        <div id="v6_pl_leftnav_group">    <div style="visibility: hidden;"></div><div class=" " style="z-index: 10; transform: translateZ(0px); position: relative; transition: margin-top 0.3s ease; will-change: margin-top, top; width: 150px;"><div class="WB_left_nav WB_left_nav_Atest" node-type="groupList" fixed-item="true" fixed-id="3">
                    <div class="lev_Box lev_Box_noborder">
                        <h3 class="lev"><a href="/u/3264426464/home?leftnav=1" class="S_txt1" node-type="item" bpfilter="main" nm="status" suda-uatrack="key=V6update_leftnavigate&amp;value=homepage"><span class="levtxt">首页</span><i class="W_new W_new_ani"><i>新微博</i></i></a></h3>
                    </div>
                    <div class="lev_Box lev_Box_noborder">
                        <h3 class="lev"><a dot="pos55b9e09c8ae74" href="/fav?leftnav=1" class="S_txt1" node-type="item" bpfilter="main" suda-uatrack="key=V6update_leftnavigate&amp;value=collect"><span class="levtxt">我的收藏</span></a></h3>
                    </div>
                    <div class="lev_Box lev_Box_noborder">
                        <h3 class="lev"><a dot="pos55b9e0b0ca122" href="/like/outbox?leftnav=1" class="S_txt1" node-type="item" bpfilter="main" suda-uatrack="key=V6update_leftnavigate&amp;value=collect"><span class="levtxt">我的赞</span><i class="W_new" like-dot="likeDot" style="display: none;"></i></a></h3>
                    </div>
                    <div class="lev_line lev_line_v2"><fieldset></fieldset></div>
                    <div class="lev_Box lev_Box_noborder">
                        <div class="lev">
                            <a page_id="102803_ctg1_1760_-_ctg1_1760" dot="" href="http://d.weibo.com" class="S_txt1" node-type="item" suda-uatrack="key=V6update_leftnavigate&amp;value=left_hotweibo"><span class="ico_block"><em class="W_ficon ficon_hot S_ficon">ì</em></span><span class="levtxt">热门微博</span><i class="W_new"></i></a>
                        </div>
                        <div class="lev">
                            <a page_id="" dot="" href="http://weibo.com/tv" class="S_txt1" node-type="item" suda-uatrack="key=V6update_leftnavigate&amp;value=left_video"><span class="ico_block"><em class="W_ficon ficon_video S_ficon">q</em></span><span class="levtxt">热门视频</span></a>
                        </div>
                        <!--
                    <div class="lev">
                        <a dot="" href="/feed/olympics?leftnav=1" class="S_txt1" node-type="item" bpfilter="main" suda-uatrack="key=V6update_leftnavigate&value=left_news""><span class="ico_block"><em class="W_ficon ficon_olympic S_ficon">&#xe60e;</em></span><span class="levtxt">里约奥运会</span></a>
                    </div>
                -->
                    </div>
                    <div class="lev_line">
                        <fieldset></fieldset>
                    </div>
                    <div node-type="leftnav_scroll" class=" UI_scrollView">
                        <div class="UI_scrollContainer">
                            <div class="UI_scrollContent" style="width: 167px;">
                                <div class="lev_Box" style="width: 150px;">
                                    <div class="lev"><a href="/friends?leftnav=1&amp;wvr=6&amp;isfriends=1&amp;step=2" title="好友圈" class="S_txt1" node-type="item" bpfilter="main" isfriends="1" nm="moments_to_me" suda-uatrack="key=V6update_leftnavigate&amp;value=friends"><span class="ico_block"><em node-type="left_item" class="W_ficon ficon_friends S_ficon">C</em></span><span class="levtxt">好友圈</span></a></div>
                                    <div node-type="system_list" specialgid="3556561203015949">
                                        <div class="lev" gid="3556561203015949" node-type="group" action-data="id=3556561203015949"><a href="/mygroups?gid=3556561203015949&amp;wvr=6&amp;leftnav=1&amp;isspecialgroup=1" class="S_txt1" title="" node-type="item" bpfilter="main" gid="3556561203015949" suda-uatrack="key=V6update_leftnavigate&amp;value=special"><span class="ico_block"><em node-type="left_item" class="W_ficon ficon_p_interest S_ficon">æ</em></span><span class="levtxt">特别关注</span><em class="W_new_count">2</em></a></div>
                                    </div>
                                    <div node-type="leftnav_grouplists">
                                        <div node-type="group_show_list">
                                            <div class="lev" gid="3734059581128800" node-type="group" action-data="id=3734059581128800"><a href="/mygroups?gid=3734059581128800&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="快男" node-type="item" bpfilter="main" gid="3734059581128800" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">快男</span></a></div>
                                            <div class="lev" gid="3788122678524000" node-type="group" action-data="id=3788122678524000"><a href="/mygroups?gid=3788122678524000&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="美女" node-type="item" bpfilter="main" gid="3788122678524000" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">美女</span></a></div>
                                            <div class="lev" gid="3800873207816552" node-type="group" action-data="id=3800873207816552"><a href="/mygroups?gid=3800873207816552&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="搞笑" node-type="item" bpfilter="main" gid="3800873207816552" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">搞笑</span><em class="W_new_count">3</em></a></div>
                                            <div class="lev" gid="3824570346134745" node-type="group" action-data="id=3824570346134745"><a href="/mygroups?gid=3824570346134745&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="治愈系" node-type="item" bpfilter="main" gid="3824570346134745" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">治愈系</span><em class="W_new_count">3</em></a></div>
                                            <div class="lev" gid="3824570371039448" node-type="group" action-data="id=3824570371039448"><a href="/mygroups?gid=3824570371039448&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="情感" node-type="item" bpfilter="main" gid="3824570371039448" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">情感</span></a></div>
                                        </div>
                                        <div node-type="moreList" style="display:none;">
                                            <div class="lev" gid="3832040418287609" node-type="group" action-data="id=3832040418287609"><a href="/mygroups?gid=3832040418287609&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="美图" node-type="item" bpfilter="main" gid="3832040418287609" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">美图</span></a></div>
                                            <div class="lev" gid="3832040434711880" node-type="group" action-data="id=3832040434711880"><a href="/mygroups?gid=3832040434711880&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="电视剧" node-type="item" bpfilter="main" gid="3832040434711880" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">电视剧</span></a></div>
                                            <div class="lev" gid="3832040476696241" node-type="group" action-data="id=3832040476696241"><a href="/mygroups?gid=3832040476696241&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="明星" node-type="item" bpfilter="main" gid="3832040476696241" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">明星</span></a></div>
                                            <div class="lev" gid="3874755830218498" node-type="group" action-data="id=3874755830218498"><a href="/mygroups?gid=3874755830218498&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="演员" node-type="item" bpfilter="main" gid="3874755830218498" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">演员</span></a></div>
                                            <div class="lev" gid="3883118631280689" node-type="group" action-data="id=3883118631280689"><a href="/mygroups?gid=3883118631280689&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="潮流" node-type="item" bpfilter="main" gid="3883118631280689" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">潮流</span><em class="W_new_count">1</em></a></div>
                                            <div class="lev" gid="3910462556990226" node-type="group" action-data="id=3910462556990226"><a href="/mygroups?gid=3910462556990226&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="街拍" node-type="item" bpfilter="main" gid="3910462556990226" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">街拍</span></a></div>
                                            <div class="lev" gid="3556561203262882" node-type="group" action-data="id=3556561203262882"><a href="/mygroups?gid=3556561203262882&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="名人明星" node-type="item" bpfilter="main" gid="3556561203262882" suda-uatrack="key=V6update_leftnavigate&amp;value=commongroup"><span class="ico_block"><em action-type="leftnav_group_front" suda-uatrack="key=V6update_leftnavigate&amp;value=stickie" class="W_ficon ficon_gotop S_ficon" title="置顶">ó</em><em node-type="left_item" class="W_ficon ficon_dot S_ficon">D</em></span><span class="levtxt">名人明星</span></a></div>
                                            <div class="lev"><a bpfilter="main" groupnm="page_group_to_me" href="/groupsfeed?leftnav=1&amp;wvr=6&amp;isgroupsfeed=1&amp;step=2" class="S_txt1" node-type="item" suda-uatrack="key=V6update_leftnavigate&amp;value=group_weibo"><span class="ico_block"><em class="W_ficon ficon_groupwb S_ficon">º</em></span><span class="levtxt">群微博</span></a></div>                <div class="lev"><a href="/mygroups?whisper=1&amp;wvr=6&amp;leftnav=1" class="S_txt1" title="悄悄关注" node-type="item" bpfilter="main" whisper="1" suda-uatrack="key=V6update_leftnavigate&amp;value=secret"><span class="ico_block"><em class="W_ficon ficon_p_quietfollow S_ficon">â</em></span><span class="levtxt">悄悄关注</span></a></div>
                                        </div>
                                    </div>
                                    <div class="levmore">
                                        <a node-type="moreBtn" action-type="moreBtn" href="javascript:void(0);" class="more S_txt1" suda-uatrack="key=V6update_leftnavigate&amp;value=unfold">
                                            展开
                                            <i class="W_new"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="UI_scrollBar W_scroll_y S_bg1" style="visibility: hidden;">
                            <div class="bar S_txt2_bg" style="top: 0%; height: 100%;">

                            </div>
                        </div>
                    </div>
                </div>
                <div style="height:1px;margin-top:-1px;visibility:hidden;">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('main')
    <div class="col-md-7" style="padding-left:0px;width:725px;margin-left:150px;margin-right:0px;">
            <div class="demo" style="background-color: white;width: 725px;margin: 0 auto;border-radius: 3px;">
                <form action="" method="post">
                    {{csrf_field()}}
                    <h3 style="width: 680px;margin: 0 auto;padding: 10px 0;margin-bottom: 15px;"><span class="counter">140</span><img src="/home/images/xin.png"></h3>
                    <textarea style="width: 650px;margin: 0 auto;margin-left:40px;" name="content" id="saytxt" class="input" tabindex="1" rows="2" cols="40"></textarea>
                    <div style="background-color: white;padding: 10px 0;border-radius: 3px;">
                        <p>
                            <div class="kind" style="width: 300px;display: inline-block;margin-left: 40px;">
                                <a class="S_txt1" href="javascript:void(0);" action-type="face" action-data="type=500&amp;action=1&amp;log=face&amp;cate=1" title="表情" node-type="smileyBtn" suda-uatrack="key=tblog_home_edit&amp;value=phiz_button"><em class="W_ficon ficon_face">o</em>表情</a>
                                <a class="S_txt1" href="javascript:void(0);" action-type="multiimage" action-data="type=508&amp;action=1&amp;log=image&amp;cate=1" title="图片" suda-uatrack="key=tblog_new_image_upload&amp;value=image_button"><em class="W_ficon ficon_image">p</em>图片</a>
                                <a class="S_txt1" href="javascript:void(0);" action-type="topic" action-data="type=504&amp;action=1&amp;log=topic&amp;cate=1" title="话题" suda-uatrack="key=tblog_home_edit&amp;value=topic_button"><em class="W_ficon ficon_swtopic">"</em>话题</a>
                                <a class="S_txt1" href="http://weibo.com/ttarticle/p/editor" target="_blank" title="头条文章" suda-uatrack="key=tblog_headline_article&amp;value=headline_article_button"><em class="W_ficon ficon_artical"></em>头条文章</a>
                                <a href="javascript:void(0);" node-type="more" class="W_ficon ficon_more S_ficon" title="查看更多">…</a>
                            </div>
                            <input class="btn btn-warning" style="float:right;margin-right:40px;display: inline-block; " type="submit" value="发布">
                            <span id="msg"></span>
                            <input type="hidden" value="{{date('Y-m-d H:i:s',time())}}" name="addtime">
                        </p>
                    </div>

                </form>
            </div>
            @foreach($say as $v)
            <div style="width: 725px;margin: 0 auto;border:1px solid #CCC;margin: 0 auto;margin-top:10px;background-color: white;border-radius: 3px;">
                <div style="width:650px;margin:0 auto;margin-top: 10px;">
                    @foreach($users as $value_name)
                        @if($value_name->id==$v->users_id)
                    <div style="float:left;">
                        <a href="{{url('home/other_per'.'/'.$v->users_id)}}"><img src="{{$value_name->avatar}}" alt="头像" width="50px;" height="50px"></a>
                    </div>

                    <div style="float:left;width:500px;">

                    <div style="height:25px;margin-left: 10px;">{{$value_name->name}}</div>

                    <div style="height:25px;font-size:15px;margin-left: 10px;">{{$v->addtime}}</div>
                     @else
                     @endif
                     @endforeach
                    </div>
                    <div style="float:right;width:50px;"><a id="del-1" style="color:#F0AD4E;" href="{{url('/home/del-1'.'/'.$v->id)}}">删除</a></div>
                </div>

                <div style="width:650px;margin:0 auto;margin-top:70px;margin-left:95px;">
                      {{$v->content}}
                </div>
                <ul class="WB_row_line WB_row_r4 clearfix S_line2">
                    <li>
                        <a class="S_txt2" href="{{url('home/collection'.'/'.$v->id)}}">
                            <span class="pos">
                                <span class="line S_line1" node-type="favorite_btn_text">
                                    <span style="font-size:15px;"><em class="W_ficon ficon_favorite S_ficon">û</em><em>收藏</em>
                                        <em style="margin-left: 10px;">{{$v->collectionNum}}</em>
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
                            <span class="pos"><span class="line S_line1" node-type="comment_btn_text" style="border-right-style: solid;border-right-width:1px;">
                                    <span  style="font-size:15px;"><em class="W_ficon ficon_repeat S_ficon"></em><em>评论</em>
                                                <em style="margin-left: 10px;">{{$v->commitNum }}</em>
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
                    <li id="yj">
                       <a href="{{url('home/zan'.'/'.$v->id)}}">
                          @if(!$v->is_zan->isEmpty())
                         {{--  @foreach($zan as $value_zan)
                               @if($value_zan->zsay_id==$v->id)--}}
                             <span class="line S_line1 status" style="border:none;margin-left:80px;float:left;width:25px;" id="praise">
                                    <img src="{{asset('home/images/upvote.png')}}" id="praise-img" />
                             </span>
                             {{--  @else
                              <span class="line S_line1 status" style="border:none;margin-left:80px;float:left;width:25px;" id="praise">
                                    <img src="{{asset('home/images/downvote.png')}}" id="praise-img" />
                              </span>
                               @endif
                           @endforeach--}}

                           @else
                               <span class="line S_line1 status" style="border:none;margin-left:80px;float:left;width:25px;" id="praise">
                                    <img src="{{asset('home/images/downvote.png')}}" id="praise-img" />
                              </span>
                           @endif
                           <span style="margin-left:10px;float:left;margin-top:3px;font-size: 15px;">
                               {{$v->zanNum}}
                           </span>
                       </a>

                    </li>
                </ul>

                <div class="ping" class="demo" style="background-color: white;width: 723px;margin: 0 auto;border-radius: 3px;display: none;">
                  <form action="Ping" method="post">
                        {{csrf_field()}}
                        <textarea style="width: 650px;margin: 0 auto;margin-left:40px;" name="commit_content" id="saytxt" class="input" tabindex="1" rows="2" cols="40"></textarea>
                        <div style="background-color: white;padding: 10px 0;border-radius: 3px;">
                            <p>
                            <input type="hidden" value="{{date('Y-m-d H:i:s',time())}}" name="commit_time">
                            <input id="zid" type="hidden" value="{{$v->id}}" name="say_id">
                            <input class="btn btn-warning" style="float:right;margin-right:40px;display: inline-block; " type="submit" value="评论">
                            <span id="msg"></span>

                            </p>
                        </div>
                    </form>

                    @foreach($commit as $value)
                        @if($value->say_id==$v->id)
                        <div style="width: 630px;margin: 0 auto;margin-top:10px;margin-bottom: 10px;background-color: white;border-radius: 3px;overflow: hidden;">
                            <div style="width:620px;margin:0 auto;margin-top: 10px;">
                                <div style="float:left;">
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
                                        <textarea style="width: 500px;height:20px;margin: 0 auto;margin-left:0px;" name="hui_content" id="saytxt" class="input" tabindex="1" rows="2" cols="40"></textarea>
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

@section('endscript')

    @endsection