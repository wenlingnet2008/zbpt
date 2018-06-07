@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.permissions.create') }}" >添加权限</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.permissions.index') }}" >管理权限</a></td>
        </tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{route('admin.permissions.update', ['permission'=>$permission->id])}}" id="dform">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 权限名称</td>
                <td>{{$permission->name}}</td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 权限描述</td>
                <td><input name="permission[desc]" type="text" size="30" value="{{ $permission->desc }}" /><br/></td>
            </tr>

            <tr>
                <td class="tl"> 权限设置</td>
                <td><input name="permission[value]" type="text" size="30" value="{{ $permission->value }}" />
                    <img src="/admin/image/tips.png" width="16" height="16" title="权限设置的值,例如 权限名称:可查看的文章数 权限设置:10" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);" /></td>
            </tr>

        </table>
        <div class="sbt"><input type="submit" name="submit" value="更新" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input
                    type="button" value="取 消" class="btn" onclick="Go('?');"/></div>

    </form>


    <script type="text/javascript">Menuon(1);</script>
@stop