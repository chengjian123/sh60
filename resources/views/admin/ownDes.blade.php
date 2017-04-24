@extends('app')
@section('iframe')
    <div class="row">

        <div class="col-md-1">

        </div>
        <div class="col-md-10">
            @foreach($result as $v)
                @if(!empty($messages))
                    {{$messages}}
                    @endif

            <form class="form-horizontal" action="/admin/ownDes/{{$id}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">头像</label>
                    <div class="col-sm-6">
                        <img src="{{url($v->avatar )}}" alt="" width="80" height="100">

                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" value="{{$v->name}}"  class="form-control" id="userName" placeholder="用户名" disabled="disabled">
                        @if(count($errors))
                            {{$errors->first('name')}}
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-6">
                        <input type="text" name="email" value="{{$v->email}}"  class="form-control" id="userEmail" placeholder="邮箱" disabled="disabled">
                        @if(count($errors))
                            {{$errors->first('email')}}
                        @endif
                    </div>
                </div>
                <div class="form-group" id="userPass" hidden="hidden">
                    <label for="inputPassword3"  class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-6">
                        <input type="password" name="password" class="form-control"  placeholder="密码" >
                        @if(count($errors))
                            {{$errors->first('password')}}
                        @endif
                    </div>
                </div>

                <div class="form-group" id="userAvatar" hidden="hidden">
                    <label for="inputPassword3"  class="col-sm-2 control-label">头像</label>
                    <div class="col-sm-6">
                        <input type="file" name="avatar" value="" class="form-control" id="avatarL" disabled="disabled">
                        @if(count($errors))
                            {{$errors->first('avatar')}}
                        @endif
                    </div>
                </div>
                <button type="submit" id="submitL" class="btn btn-primary" disabled="disabled" >提交</button>
                <br>
                <br>


                <button class="btn btn-primary" onclick="history.go(-1)" >返回</button>



            </form>
                <br>
                <button  class="btn btn-primary" id="changeL" >修改</button>
            @endforeach
        </div>
        <div class="col-md-1"></div>

    </div>
@endsection
@section('script')
    <script>
        $('#changeL').toggle(
            function () {
                $('#submitL').attr('disabled',false);
                $('#userName').attr('disabled',false);
                $('#userEmail').attr('disabled',false);
                $('#avatarL').attr('disabled',false);
                $('#userPass').attr('hidden',false);
                $('#userAvatar').attr('hidden',false);
                $('#changeL').html('取消');
            },
            function () {
                $('#submitL').attr('disabled',true);
                $('#userName').attr('disabled',true);
                $('#userEmail').attr('disabled',true);
                $('#avatarL').attr('disabled',true);
                $('#userPass').attr('hidden',true);
                $('#userAvatar').attr('hidden',true);
                $('#changeL').html('修改');
            }

            );

    </script>
    @endsection
@section('title')
    个人信息
@endsection