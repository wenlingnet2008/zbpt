@extends('layouts.admin.layout')


@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab_on"><a href="{{ route('admin.server') }}" >服务管理</a></td>
        </tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <div id="Tabs0" style="display:">
    <table cellspacing="0" class="tb">
        <tr>
            <td class="tl">聊天服务</td>
            <td><a href="{{route('admin.server', ['service'=>'chat', 'action'=>'restart'])}}">重启</a> </td>
        </tr>
        <tr>
            <td class="tl">机器人服务</td>
            <td><a href="{{route('admin.server', ['service'=>'robot', 'action'=>'restart'])}}">重启</a>  </td>
        </tr>

    </table>
        <div class="sbt">建议不要频繁重启</div>
    </div>
@stop