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

    <form method="post">
        {{csrf_field()}}

        <table cellspacing="0" class="tb ls">
            <tr>
                <th>ID</th>
                <th>权限名称</th>
                <th>权限描述</th>
                <th>设置</th>
                <th width="100">操作</th>

            </tr>
            @foreach($permissions as $permission)
                <tr align="center">
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->desc }}</td>
                    <td>{{ $permission->value }}</td>
                    <td><a href="{{route('admin.permissions.edit', ['permission'=>$permission->id])}}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
                    </td>

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
                    url: "{{ url('admin/permissions') }}/"+ id,
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