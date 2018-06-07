<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8"/>
    <title>管理中心</title>
    <meta name="robots" content="noindex,nofollow"/>
    <meta name="generator" content="DESTOON B2B - www.destoon.com"/>
    <meta http-equiv="x-ua-compatible" content="IE=8"/>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    <link rel="bookmark" type="image/x-icon" href="favicon.ico"/>
</head>
<noscript><br/><br/><br/><center><h1>您的浏览器不支持JAVASCRIPT,请更换支持JAVASCRIPT的浏览器</h1></center></noscript>
<noframes><br/><br/><br/><center><h1>您的浏览器不支持框架,请更换支持框架的浏览器</h1></center></noframes>
<script type="text/javascript" src="{{ asset('admin/script/config.js') }}"></script>
<frameset cols="218,*" frameborder="no" border="0" framespacing="0" name="fra">
    <frame name="left" noresize scrolling="auto" src="{{ route('admin.left') }}?rand={{ time() }}">
    <frame name="main" noresize scrolling="yes" src="{{route('admin.dash.main')}}?rand={{ time() }}">
</frameset>
</html>