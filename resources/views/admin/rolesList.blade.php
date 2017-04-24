@extends('app')
@section('iframe')
    <ul class="nav nav-pills">
        <li role="presentation" ><a href="{{url('admin/rolesAdd')}}">+新增角色</a></li>

    </ul>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-2"></div>
        <div class="col-md-6">

            <form class="form-inline" action="{{url('admin/roleSearch')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                    <div class="input-group">
                        <div class="input-group-addon">O_O</div>
                        <input type="text" class="form-control" name="search" id="exampleInputAmount" placeholder="输入权限名称">
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
            <table class="table table-bordered" >
                <tr class="active">
                    <th>ID</th>
                    <th>权限路由</th>
                    <th>权限名称</th>
                    <th>权限描述</th>
                    <th>角色权限</th>
                    <th>操作</th>
                </tr>
               @if(!$roles[0])
                    <tr>
                        <td colspan="6"><h2>暂无角色......</h2></td>
                    </tr>
                   @else

                    @foreach($roles as $role)
                        <tr>
                            <td >{{$role->id}}</td>
                            <td >{{$role->name}}</td>
                            <td >{{$role->display_name}}</td>
                            <td >{{$role->description}}</td>
                            <td >{{$role->perms}}</td>
                            <td >
                                <a href="{{url('admin/rolesUpdate').'/'.$role->id }}" type="button" class="btn btn-info">修改</a>
                                <a href="{{url('admin/attachPermission').'/'.$role->id }}" type="button" class="btn btn-info">分配权限</a>
                                <a href="{{url('admin/rolesDel').'/'.$role->id }}" type="button" class="btn btn-danger">删除</a>

                            </td>
                        </tr>
                    @endforeach

                   @endif

            </table>
            {{$roles->links()}}
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
@section('title')
    角色管理
@endsection