@include("zhangmazi::ueditor")
@extends('app')
@section('heahScript')
    <script type="text/javascript" src="{{asset('/assets/ue/ueditor.config.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/ue/ueditor.all.min.js')}}"> </script>
    <script type="text/javascript" src="{{asset('/assets/ue/lang/zh-cn/zh-cn.js')}}"></script>

    <script>

        $(function() {
            //本来是这样的:UE.getEditor('editor');  传入参数后就是下面那样子了，toolbars里的就是工具的图标
            UE.getEditor('ueditor_filed', {
                toolbars: [

                ]
            });
        })
    </script>
    @endsection
@section('iframe')
    <ul class="nav nav-pills">
        {{--<li role="presentation" ><a href="{{url('admin/usersAdd')}}">+新增管理员</a></li>--}}
        <li role="presentation"><a href="" onclick="history.go(-1)">返回</a></li>
        {{--<li role="presentation"><a href="#">Messages</a></li>--}}
    </ul>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">

                <div class="row">
                    <label for="inputPassword3" class="col-sm-2 control-label">新闻类别</label>
                    <div class="col-xs-2">
                        <select class="form-control" id="disabledInput"  name="type_id" disabled>
                            @foreach($types as $v)
                                <option value=" {{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>
            @foreach($result as $value)
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="disabledInput" placeholder="{{$value->title}}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-10">


                        <textarea name='' id='ueditor_filed' disabled="disabled">{{$value->content}}</textarea>
                        {{--<textarea name='' id='content' disabled="disabled">{{$value->content}}</textarea>--}}



                    </div>
                </div>
            @endforeach

        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('title')
    新闻详情
@endsection
@section('script')

@endsection