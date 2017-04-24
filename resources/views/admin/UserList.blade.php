@extends('app')
@section('iframe')
    <ul class="nav nav-pills">
        {{--<li role="presentation" ><a href="{{url('admin/usersAdd')}}">+新增管理员</a></li>--}}
        <li role="presentation"><a href="" onclick="history.go(-1)">返回</a></li>
        {{--<li role="presentation"><a href="#">Messages</a></li>--}}
    </ul>
    {{--搜索分页--}}
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-6">

            <form class="form-inline" action="{{url('admin/UserSearch')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                    <div class="input-group">
                        <div class="input-group-addon">O_O</div>
                        <input type="text" class="form-control" name="search" id="exampleInputAmount" placeholder="输入用户名">
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
        <div class="col-md-1"></div>
        <div class="col-md-10">
            @if($users[0])
                共计 {{$count}} 名用户

            <table class="table table-hover">
                <tr class="active">
                    <th>ID</th>
                    <th>用户名</th>
                    <th>邮箱</th>
                    <th>角色名称</th>
                    <th>操作</th>
                </tr>


                    @foreach($users as $userL)
                        <tr >
                            <td class="danger">{{$userL->id}}</td>
                            <td >{{$userL->name}}</td>
                            <td >{{$userL->email}}</td>
                            <td >{{$display_name}}</td>

                            <td >
                                <a href="usersRe/{{$userL->id }}" type="button" class="btn btn-danger">重置密码</a>

                                    @if($userL->disable==0)
                                    <a href="usersDisable/{{$userL->id }}" type="button" class="btn btn-info">已启用</a>
                                        @else
                                        <a href="usersAble/{{$userL->id }}" type="buttn" class="btn btn-danger">已禁用 </a>
                                        @endif


                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5"><h2>暂无角色......</h2></td>
                    </tr>
                @endif
            </table>

            {{$users->links()}}
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('title')
用户管理
@endsection