<!DOCTYPE html>
<html>
<head>
    {{--此处 @yield传递了两个参数，第一个是该区块的变量名称，第二个是默认值--}}
    <title>@yield('title','Laravel')</title>

    {{--laravel运行时 ，是以public文件夹为根目录的 。所以此处我们的路径这样写--}}
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
        {{--引用视图--}}
    @include('layouts._header')
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            {{--该占位区域将用于显示 content 区块的内容，content 的内容将由继承自default视图的子视图定义--}}
           @include('shared._messages')
            @yield('content')
            @include('layouts._footer')
        </div>
    </div>
    <script src="{{asset('/js/app.js')}}"></script>
</body>
</html>