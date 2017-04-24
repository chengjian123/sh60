@extends('app')
@section('iframe')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" action="/admin/permissionUpdate/{{$permission->id}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">分类:</label>
                    <div class="col-sm-6">
                        <select name="" id="" class="form-control" value="">
                            <option value="">==请选择==</option>
                            <option value="admin">admin</option>
                            <option value="home">home</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">权限路由</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" value="{{$permission->name}}"  class="form-control" id="inputEmail3" placeholder="权限路由">
                        @if(count($errors))
                            {{$errors->first('name')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3"  class="col-sm-2 control-label">权限名称</label>
                    <div class="col-sm-6">
                        <input type="text" name="display_name" value="{{$permission->display_name}}" class="form-control" id="inputPassword3" placeholder="权限名称">
                        @if(count($errors))
                            {{$errors->first('display_name')}}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3"  class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <textarea class="form-control"  rows="3" name="description"  >{{$permission->description}}</textarea>
                        @if(count($errors))
                            {{$errors->first('description')}}
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">添加</button>
            </form>

        </div>
        <div class="col-md-1"></div>

    </div>
@endsection
@section('title')
    新增权限
@endsection