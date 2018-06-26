@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.dash.main') }}" >系统首页</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.dash.password') }}" >修改密码</a></td>
            <td id="Tab2" class="tab"><a href="javascript:Dconfirm('确定要退出管理后台吗?', '{{ route('admin.logout') }}');" >安全退出</a></td></tr>
    </table>
@stop

@section('content')

    <style type="text/css">
        #todo {display:none;width:100%;border-bottom:#E7E7EB 1px solid;padding-bottom:10px;}
        #todo ul {margin-top:10px;}
        #todo li {float:left;width:180px;line-height:32px;padding:0 16px;}
        #todo li b {color:red;padding:0 2px;font-size:12px;}
    </style>

    <div class="tt"><span class="f_r px12" style="font-weight:normal;"></span>欢迎{{$role->name}}，{{ $user->name }}</div>
    <!--<table cellspacing="0" class="tb">
        <tr>
            <td class="tl">管理级别</td>
            <td width="30%">&nbsp;网站创始人</td>
            <td class="tl">登录次数</td>
            <td width="30%">&nbsp;6 次</td>
        </tr>
        <tr>
            <td class="tl">站内信件</td>
            <td>&nbsp;<a href="http://192.168.0.38/member/message.php" target="_blank">收件箱(0)</a></td>
            <td class="tl">登录时间</td>
            <td>&nbsp;2018-05-16 14:34 </td>
        </tr>
        <tr>
            <td class="tl">账户余额</td>
            <td>&nbsp;0.00</td>
            <td class="tl">会员积分</td>
            <td>&nbsp;0 </td>
        </tr>

    </table>
    -->
    <div id="todo"></div>
    <div id="destoon"></div>
    <div class="tt">系统信息 </div>
    <table cellspacing="0" class="tb">
        <tr><td>站点名称</td><td>
            {{ $site_name->value }}</td></tr>
        <tr><td>站点URL</td><td>
                {{ url('/') }}</td></tr>
        <tr><td>程序版本</td><td>
                1.0</td></tr>
        <tr><td>服务器</td><td>
                {{ $sysinfo['server'] }}</td></tr>
        <tr><td>web服务</td><td>
                {{ $sysinfo['webserver'] }}</td></tr>
        <tr><td>内存</td><td>
                {{ $sysinfo['memory'] }}</td></tr>
        <tr><td>Laravel 版本</td><td>
                {{ $sysinfo['laraver'] }} 本程序使用<a href="https://www.laravel.com" target="_blank"> Laravel框架 </a></td></tr>
        <tr><td>服务器timezone</td><td>
                {{ $sysinfo['timezone'] }}</td></tr>

        <tr><td>最大上传文件</td><td>
                {{ $sysinfo['upload_max_filesize'] }}</td></tr>
        <tr><td>Mysql 版本</td><td>
                {{ $sysinfo['mysql'] }}</td></tr>
        <tr><td>PHP 版本</td><td>
                {{ $sysinfo['php'] }}</td></tr>
        <tr><td>服务器IP</td><td>
                {{ $sysinfo['ip'] }}</td></tr>

    </table>

    <script type="text/javascript">Menuon(0);</script>

@endsection
