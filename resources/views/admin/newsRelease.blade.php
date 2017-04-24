@include("zhangmazi::ueditor")
@extends('app')
@section('iframe')
    <ul class="nav nav-pills">
        {{--<li role="presentation" ><a href="{{url('admin/usersAdd')}}">+新增管理员</a></li>--}}
        <li role="presentation"><a href="" onclick="history.go(-1)">返回</a></li>
        {{--<li role="presentation"><a href="#">Messages</a></li>--}}
    </ul>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" action="{{url('admin/newsRelease')}}" method="post" >
                {{csrf_field()}}
                <div class="row">
                    <label for="inputPassword3" class="col-sm-2 control-label">新闻类别</label>
                    <div class="col-xs-2">
                    <select class="form-control"  name="type_id" >
                        <option value=" ">请选择</option>
                        @foreach($types as $v)
                        <option value=" {{$v->id}}">{{$v->name}}</option>
                            @endforeach
                    </select>
                        <br>
                    </div>
                    @if(count($errors))
                        {{$errors->first('type_id')}}
                    @endif
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="标题">
                        @if(count($errors))
                            {{$errors->first('title')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">内容</label>
                    <div class="col-sm-10">
                        <script id="ueditor_filed" name="article_content" type="text/plain"></script>
                        @if(count($errors))
                            {{$errors->first('article_content')}}
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">发布</button>

                    </div>
                </div>
            </form>



        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('title')
    新闻发布
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('/assets/ue/ueditor.config.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/ue/ueditor.all.min.js')}}"> </script>
    <script type="text/javascript" src="{{asset('/assets/ue/lang/zh-cn/zh-cn.js')}}"></script>
    <script>

        $(function() {
           	    //本来是这样的:UE.getEditor('editor');  传入参数后就是下面那样子了，toolbars里的就是工具的图标
               UE.getEditor('ueditor_filed', {
                         toolbars: [
                    ['fullscreen',  'undo', 'redo', 'bold', 'italic',
                    'underline','fontborder', 'backcolor', 'fontsize', 'fontfamily',
                    'justifyleft', 'justifyright','justifycenter', 'justifyjustify',
                    'strikethrough','superscript', 'subscript', 'removeformat',
                    'formatmatch', 'pasteplain', '|',
                    'forecolor', 'backcolor','insertorderedlist',
                    'selectall', 'cleardoc', 'link', 'unlink','emotion', 'help']
                	          ]
            	    });
            	})

        {{--var ueditor_full = UE.getEditor('ueditor_filed', {--}}
            {{--'serverUrl' : '{{ route("zhangmazi_front_ueditor_service", ['_token' => csrf_token()]) }}'--}}
        {{--});--}}
    </script>
    @endsection