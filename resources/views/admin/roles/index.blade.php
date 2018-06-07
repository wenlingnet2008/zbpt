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

    <form method="post">
        {{csrf_field()}}

        <table cellspacing="0" class="tb ls">
            <tr>
                <th>ID</th>
                <th>分组名称</th>
                <th>类型</th>
                <th width="40">修改</th>
                <th width="40">删除</th>
            </tr>
                @foreach($roles as $role)
                <tr align="center">
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->type }}</td>
                    <td><a href="{{ route('admin.roles.edit', ['role'=>$role->id]) }}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;</td>
                    <td>@if($role->type != '系统')<a href="#" onclick="del({{$role->id}})"><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>@endif</td>
                </tr>
               @endforeach

        </table>

    </form>

    <script type="text/javascript">Menuon(1);</script>
    <script>
        function del(id) {
            var r=confirm("注意：确定要删除吗?");
            if (r==true)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/roles') }}/"+ id,
                    data: "_token={{ csrf_token() }}",
                    success: function(msg){
                        alert( msg.message );
                        location.reload();
                    }
                });
            }
        }
    </script>
@stop