@extends('layouts.default')

{{-- 当 @section传递了第二个参数时，便不再需要通过 @stop告诉laravel填充区块在具体哪个位置结束--}}
@section('title','Home')

{{--使用 @section和 @stop 填充父视图的content区块--}}
@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            你现在所看到的是 <a href="https://learnku.com/courses/laravel-essential-training/5.5">Laravel 入门教程</a> 的示例项目主页。
        </p>
        <p>
            一切，将从这里开始。
        </p>
        <p>
            <a class="btn btn-success" href="{{route('signup')}}" role="button">register now</a>
        </p>
    </div>
@stop