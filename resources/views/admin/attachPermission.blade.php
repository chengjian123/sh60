@extends('app')
@section('iframe')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-8">
        <label for="exampleInputName2">分配权限：</label><br><br>
        <form  class="form-inline" action="{{url('admin/attachPermission').'/'.$role_id}}" method="post">
            {{csrf_field()}}
            <div class="checkbox">
                @foreach($permissions as $permission)
                    <label><input type="checkbox" name="permission_id[]" value="{{$permission->id}}">{{$permission->display_name}}</label>
                @endforeach
            </div>
            <br><br>

            <button type="submit" class="btn btn-success">提交</button>
            <a  type="button" class="btn btn-info" onclick="history.go(-1)">返回</a>
        </form>


    </div>
    <div class="col-md-1"></div>
</div>
@endsection
@section('title')
    分配权限
@endsection