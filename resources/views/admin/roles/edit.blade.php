@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.roles.create') }}" >添加用户组</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.roles.index') }}" >管理用户组</a></td>
        </tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{route('admin.roles.update', ['role'=>$role->id])}}" id="dform">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 会员组名称</td>
                <td>{{ $role->name }}</td>
            </tr>


            <tr>
                <td class="tl"> 后台权限</td>
                <td>
                    <span id="permission_list">
                    @foreach($permissions as $k => $permission)
                        <input type="checkbox" name="permissions[]" value="{{$permission->name}}" @if(in_array($permission->name, $role_permissions)) checked @endif id="menu_c_{{$k}}"><label for="menu_c_{{$k}}"> {{ $permission->desc }}</label>&nbsp;&nbsp;
                    @endforeach
                    </span>
                    <a href="javascript:check_box('permission_list', true);" class="t">全选</a> / <a href="javascript:check_box('permission_list', false);" class="t">全不选</a>
                </td>
            </tr>

        </table>
        <div class="sbt"><input type="submit" name="submit" value="更新" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input
                    type="button" value="取 消" class="btn" onclick="Go('?');"/></div>

    </form>



    <script type="text/javascript">Menuon(1);</script>
@stop