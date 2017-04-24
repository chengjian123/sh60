@extends('app')
@section('iframe')
    <ul class="nav nav-pills">
        {{--<li role="presentation" ><a href="{{url('admin/typeAdd')}}">+新增新闻类别</a></li>--}}
        <li role="presentation"><a href="" onclick="history.go(-1)">返回</a></li>
        {{--<li role="presentation"><a href="#">Messages</a></li>--}}
    </ul>

    {{--搜索分页--}}
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-6">

            <form class="form-inline" action="{{url('admin/newsSearch')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                    <div class="input-group">
                        <div class="input-group-addon">O_O</div>
                        <input type="text" class="form-control" name="search" id="exampleInputAmount" placeholder="输入新闻标题">
                        <div class="input-group-addon">
                            <button type="submit" class="btn btn-primary btn-xs ">搜索</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-1"></div>
        <div class="col-md-1"></div>
    </div>
    <br>


    <div class="row">
        <div class="col-md-1">
            @if(!empty($text))
                删除成功
            @else
            @endif</div>
        <div class="col-md-10">
                共计 {{$count}} 条数据
            <table class="table table-hover">
                <tr class="active">
                    <th>ID</th>
                    <th>作者</th>
                    <th>邮箱</th>
                    <th>标题</th>
                    <th>类型</th>

                    <th>操作</th>
                </tr>

                @if($result[0])
                    @foreach($result as $v)
                        <tr >
                            <td class="danger">{{$v->id}}</td>
                            <td >{{$v->name}}</td>
                            <td >{{$v->email}}</td>
                            <td >{{$v->title}}</td>
                            {{--<script type="text/plain" id="editor">--}}


                            {{--</script>--}}
                            <td >{{$v->type}}</td>


                            <td >

                                <a href="{{url('admin/newsType').'/'.$v->id}}" type="button" class="btn btn-danger">更改类型</a>
                                <a href="{{url('admin/newsDes').'/'.$v->id}}" type="button" class="btn btn-info">查看内容</a>
                                <a href="newsDel/{{$v->id}}" type="buttn" class="btn btn-danger">删除 </a>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6"><h2>暂无内容.....</h2></td>
                    </tr>
                @endif
            </table>

            {{$result->links()}}
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('title')
    新闻管理
@endsection