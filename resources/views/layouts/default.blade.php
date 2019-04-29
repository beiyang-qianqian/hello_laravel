<!DOCTYPE html>
<html>
<head>
    {{--此处 @yield传递了两个参数，第一个是该区块的变量名称，第二个是默认值--}}
    <title>@yield('title','Laravel')</title>
</head>
<body>
{{--该占位区域将用于显示 content 区块的内容，content 的内容将由继承自default视图的子视图定义--}}
@yield('content')
</body>
</html>