@extends('app')
@section('iframe')
    <ul class="nav nav-pills">
        <li role="presentation" ><a href="{{url('admin/typeAdd')}}">+新增新闻类别</a></li>
        <li role="presentation"><a href="" onclick="history.go(-1)">返回</a></li>
        {{--<li role="presentation"><a href="#">Messages</a></li>--}}
    </ul>
    <div class="row">
        <div class="col-md-1">
            @if(!empty($text))
                删除成功
            @else
            @endif</div>
        <div class="col-md-10">

            <table class="table table-bordered">
                <tr class="active">
                    <th>ID</th>
                    <th>类名</th>

                    <th>操作</th>
                </tr>

                @if($types)
                    @foreach($types as $v)
                        <tr class="active">
                            <td>{{$v->id}}</td>
                            <td >{{$v->name}}</td>

                            <td >



                                <a href="newsTypeDel/{{$v->id}}" type="buttn" class="btn btn-danger">删除 </a>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3"><h2>暂无内容.....</h2></td>
                    </tr>
                @endif
            </table>

            {{--{{$result->links()}}--}}
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('title')
    新闻类别
@endsection