@extends('app')
@section('iframe')
    <ul class="nav nav-pills">
        <li role="presentation" ><a href="{{url('admin/permissionAdd')}}">+新增权限</a></li>
        @if($mess)
        <li role="presentation"><a href="#">{{$mess}}</a></li>
        @endif
        {{--<li role="presentation"><a href="#">Messages</a></li>--}}
    </ul>

    {{--搜索分页--}}
  <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-2"></div>
      <div class="col-md-6">

          <form class="form-inline" action="{{url('admin/permSearch')}}" method="post">
              {{csrf_field()}}
              <div class="form-group">
                  <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                  <div class="input-group">
                      <div class="input-group-addon">O_O</div>
                      <input type="text" class="form-control" name="search" id="exampleInputAmount" placeholder="输入权限路由">
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
        <table class="table table-hover" >
            <tr class="active">
                <th>ID</th>
                <th>权限路由</th>
                <th>权限名称</th>
                <th>权限描述</th>
                <th>操作</th>
            </tr>
            @if(empty($permissions[0]))
                <tr >
                    <td colspan="5">
                        <h2>暂无内容.....</h2>
                    </td>
                </tr>
            @else
                @foreach($permissions as $permission)
                    <tr >
                        <td class="danger">{{$permission->id}}</td>
                        <td >{{$permission->name}}</td>
                        <td >{{$permission->display_name}}</td>
                        <td >{{$permission->description}}</td>
                        <td >
                            <a href="{{url('admin/permissionUpdate').'/'.$permission->id }}" type="button" class="btn btn-info">修改</a>
                            <a href="{{url('admin/permissionDel').'/'.$permission->id }}" type="button" class="btn btn-danger">删除</a>

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