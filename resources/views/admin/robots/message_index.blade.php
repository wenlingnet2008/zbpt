@extends('layouts.admin.layout')

@section('menu')
<table cellpadding="0" cellspacing="0">
    <tr>
        <td id="Tab0" class="tab"><a href="{{route('admin.robotmessages.create')}}">添加机器人发言</a></td>
        <td id="Tab1" class="tab"><a href="{{route('admin.robotmessages.index')}}">发言列表</a></td>
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
            <th>内容</th>
            <th width="40">删除</th>
        </tr>
        @foreach($messages as $message)
        <tr align="center">
            <td>{{ $message->id }}</td>
            <td>{{ $message->content }}</td>
            <td><a href="#" onclick="del({{$message->id}})"><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
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
                url: "{{ url('admin/robotmessages') }}/"+ id,
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