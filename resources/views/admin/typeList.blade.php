@extends('app')
@section('iframe')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-8">
            <label for="exampleInputName2">更改类型：</label><br><br>
            <form  class="form-inline" action="{{url('admin/newsType').'/'.$id}}" method="post">
                {{csrf_field()}}
                <div class="checkbox">
                    @foreach($types as $v)
                        <label><input type="radio" name="type_id" value="{{$v->id}}">{{$v->name}}</label>
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
    更改类型
@endsection