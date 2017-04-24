@extends('app')
@section('iframe')
    @if($mess)
        <i class="btn btn-danger">  {{$mess}}</i>
        <button class="btn btn-primary" onclick="history.go(-1)" >返回</button>
        @endif

    <h1> 请严格遵守管理员规定 <small>违者严惩不怠</small></h1>
    <h2> 请严格遵守管理员规定 <small>违者严惩不怠</small></h2>
    <h3> 请严格遵守管理员规定 <small>违者严惩不怠</small></h3>
    <h4> 请严格遵守管理员规定 <small>违者严惩不怠</small></h4>
    <h5> 请严格遵守管理员规定 <small>违者严惩不怠</small></h5>
    <h6> 请严格遵守管理员规定 <small>违者严惩不怠</small></h6>
@endsection
@section('script')
    <script>
        var titleL = document.getElementById('titleL');
        titleL.style.display='none';
    </script>
    @endsection
