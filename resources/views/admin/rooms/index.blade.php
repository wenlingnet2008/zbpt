@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{route('admin.rooms.create')}}">添加房间</a></td>
            <td id="Tab1" class="tab"><a href="{{route('admin.rooms.index')}}">房间列表</a></td>
        </tr>
    </table>
@stop

@section('content')
    <div class="sbox">
        <form action="?">

            <input type="text" size="30" name="q" value="" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
            <input type="submit" name="submit" value="搜 索" class="btn"/>&nbsp;

        </form>
    </div>
    <form method="post">
        {{csrf_field()}}
        <table cellspacing="0" class="tb ls">
            <tr>

                <th>房间号</th>
                <th>房间名</th>
                <th>状态</th>
                <th>Logo</th>
                <th>所有者/代理商</th>
                <th>讲师</th>
                <th width="100">操作</th>
            </tr>
            @foreach($rooms as $room)
                <tr align="center">
                    <td>{{ $room->id }}</td>
                    <td>{{$room->name}}</td>
                    <td>@if($room->open) 开启 @else 关闭 @endif</td>
                    <td><img src="/storage/{{$room->logo}}" width="100" height="100"> </td>
                    <td>@if($room->owner){{ $room->owner->name }}@endif </td>
                    <td>{{ $room->teacher->name }} </td>
                    <td>
                        <a href="{{ route('admin.rooms.show', ['order'=>$room->id]) }}">查看</a>&nbsp;
                        <a href="{{ route('admin.rooms.edit', ['order'=>$room->id]) }}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
                        <a href="#" onclick=""><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
                </tr>
            @endforeach
        </table>

    </form>
    <div class="btns">
        {{ $rooms->links() }}
    </div>
    <script type="text/javascript">Menuon(1);</script>
    <script>
        function del(id) {
            var r=confirm("注意：确定要删除吗?");
            if (r==true)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/orders') }}/"+ id,
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