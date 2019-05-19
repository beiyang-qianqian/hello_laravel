@extends('layouts.default')
@section('title','列表')
@section('content')
    <div class="col-md-offset-2 col-md-8">
        <h1>所有用户</h1>
        <ul class="users">
            @foreach ($users as $user)
                {{--所有在浮视图中可用的变量在被引入的视图中都是可用的--}}
               {{--@include('users._user',['user'=>$user]);--}}{{-- 等同于下面的写法--}}
               @include('users._user')
            @endforeach
        </ul>
        {!! $users->render() !!}
    </div>

@endsection