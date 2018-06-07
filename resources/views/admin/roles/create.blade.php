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
    <form method="post" action="{{route('admin.roles.store')}}" id="dform" onsubmit="return check();">
        {{csrf_field()}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 会员组名称</td>
                <td><input name="role[name]" type="text" size="30" value="{{ old('role.name') }}" id="name"/>
                    <span id="dname" class="f_red"></span></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 会员组类型</td>
                <td><input name="role[type]" type="text" size="30" value="{{ old('role.type') }}" /><br/></td>
            </tr>

            <tr>
                <td class="tl"> 后台权限</td>
                <td>
                    <span id="permission_list">
                    @foreach($permissions as $k => $permission)
                    <input type="checkbox" name="permissions[]" value="{{$permission->name}}"  id="menu_c_{{$k}}"><label for="menu_c_{{$k}}"> {{ $permission->desc }}</label>
                    @endforeach
                    </span>
                    <a href="javascript:check_box('permission_list', true);" class="t">全选</a> / <a href="javascript:check_box('permission_list', false);" class="t">全不选</a>

                </td>
            </tr>

        </table>
        <div class="sbt"><input type="submit" name="submit" value="添 加" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input
                    type="button" value="取 消" class="btn" onclick="Go('?');"/></div>

    </form>

    <script type="text/javascript">
        function check() {
            if (Dd('name').value == '') {
                Dmsg('请填写名称', 'name');
                return false;
            }
            return true;
        }
    </script>

    <script type="text/javascript">Menuon(0);</script>
@stop