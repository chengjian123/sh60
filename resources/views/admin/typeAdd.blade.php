@extends('app')
@section('iframe')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10"><br>
            <form class="form-horizontal" action="{{url('admin/typeAdd')}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">新闻类别</label>
                    <div class="col-sm-6">
                        <input type="text" name="name"  class="form-control" id="inputEmail3" placeholder="新闻类别">
                   @if(count($errors))
                       {{$errors->first('name')}}
                       @endif
                    </div>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>


            </form>
        </div>
        <div class="col-md-1"></div>

    </div>
@endsection
@section('title')
    新增新闻类别
@endsection