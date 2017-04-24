@extends('app')
@section('iframe')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" action="/admin/roleUpdate/{{$role_id}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">角色名称</label>
                    <div class="col-sm-6">
                        <input type="text" name="name"  class="form-control" id="inputEmail3" value="{{$role->name}}" placeholder="角色名称">
                        @if(count($errors))
                            {{$errors->first('name')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3"  class="col-sm-2 control-label">角色描述</label>
                    <div class="col-sm-6">
                        <input type="text" name="display_name" class="form-control" value="{{$role->display_name}}" id="inputPassword3" placeholder="角色描述">
                        @if(count($errors))
                            {{$errors->first('display_name')}}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3"  class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-offset-2 col-sm-10">
                        <textarea class="form-control" rows="3" name="description">{{$role->description}}</textarea>
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
    角色修改
@endsection