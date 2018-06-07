<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8"/>
    <meta name="robots" content="noindex,nofollow"/>
    <title>提示信息</title>
    <link rel="stylesheet" href="{{ asset('admin/image/msg.css') }}" type="text/css" />
    <script type="text/javascript" src="{{ asset('admin/script/config.js') }}"></script>
</head>
<body onkeydown="if(event.keyCode==13) window.history.back();">
<div class="msg">
    <div class="head">提示信息</div>
    <div class="main">
        @isset($status)
            {{ $status }}
        @endisset
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                {{ $error }} <br/>
            @endforeach
        @endif

        @isset($permission)
            {{$permission}}
        @endisset

    </div>

    @if(count($errors) > 0)
    <a href="javascript:window.history.back();"><div class="foot">点这里返回上一页</div></a>
    @endif

    @isset($status)
    <a href="{{ url()->previous() }}"><div class="foot">如果您的浏览器没有自动跳转，请点击这里</div></a>
    <meta http-equiv="refresh" content="2;URL={{ url()->previous() }}">
    @endisset
</div>
</body>
</html>