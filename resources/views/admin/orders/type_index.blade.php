@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.ordertypes.create') }}" >添加品种</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.ordertypes.index') }}" >品种列表</a></td>
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
                <th>品种名称</th>
                <th width="40">修改</th>
                <th width="40">删除</th>
            </tr>
            @foreach($order_types as $order_type)
                <tr align="center">
                    <td>{{ $order_type->id }}</td>
                    <td>{{ $order_type->name }}</td>
                    <td><a href="{{ route('admin.ordertypes.edit', ['ordertype'=>$order_type->id]) }}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;</td>
                    <td><a href="#" onclick="del({{$order_type->id}})"><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
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
                    url: "{{ url('admin/ordertypes') }}/"+ id,
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