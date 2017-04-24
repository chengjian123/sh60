@extends('app')
@section('iframe')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" action="{{url('admin/usersAdd')}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">管理员名称</label>
                    <div class="col-sm-6">
                        <input type="text" name="name"  class="form-control" id="inputEmail3" placeholder="管理员名称">
                        @if(count($errors))
                            {{$errors->first('name')}}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3"  class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-6">
                        <input type="text" name="email" class="form-control" id="inputPassword3" placeholder="邮箱">
                        @if(count($errors))
                            {{$errors->first('email')}}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword3"  class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-6">
                        <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="password">
                        @if(count($errors))
                            {{$errors->first('password')}}
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
    新增管理员
@endsection