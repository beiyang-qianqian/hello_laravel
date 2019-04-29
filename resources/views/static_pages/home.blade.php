@extends('layouts.default')

{{-- 当 @section传递了第二个参数时，便不再需要通过 @stop告诉laravel填充区块在具体哪个位置结束--}}
@section('title','Home')

{{--使用 @section和 @stop 填充父视图的content区块--}}
@section('content')
    <h1>主页</h1>
@stop