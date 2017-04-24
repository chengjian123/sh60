@extends('app')
@section('iframe')
    <ul class="nav nav-pills">
        <li role="presentation" ><a href="{{url('admin/permissionAdd')}}">+新增权限</a></li>
        <li role="presentation"><a href="" onclick="history.go(-1)">返回</a></li>
        {{--<li role="presentation"><a href="#">Messages</a></li>--}}
    </ul>



    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table table-bordered" >
                <tr class="active">
                    <th>ID</th>
                    <th>权限路由</th>
                    <th>权限名称</th>
                    <th>权限描述</th>
                    <th>操作</th>
                </tr>
                @if(empty($permissions[0]))
                    <tr>
                        <td colspan="5">
                            <h2>暂无内容.....</h2>
                        </td>
                    </tr>
                @else
                    @foreach($permissions as $permission)
                        <tr>
                            <td >{{$permission->id}}</td>
                            <td >{{$permission->name}}</td>
                            <td >{{$permission->display_name}}</td>
                            <td >{{$permission->description}}</td>
                            <td >
                                <a href="permissionUpdate/{{$permission->id }}" type="button" class="btn btn-info">修改</a>
                                <a href="permissionDel/{{$permission->id }}" type="button" class="btn btn-danger">删除</a>

                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
            {{$permissions->links()}}
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('title')
    权限管理
@endsection