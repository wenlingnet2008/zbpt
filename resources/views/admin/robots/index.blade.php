@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{route('admin.robots.create')}}">添加机器人</a></td>
            <td id="Tab1" class="tab"><a href="{{route('admin.robots.index')}}">机器人列表</a></td>
        </tr>

    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form action="" method="get">
        <table cellspacing="0" class="tb">
            <tr>
                <td>&nbsp;
                    <select name="fields">
                        <option value="0">按条件</option>

                    </select>&nbsp;
                    <input type="text" size="20" name="kw" value="" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;

                    <input type="text" name="psize" value="20" size="2" class="t_c" title="条/页"/>&nbsp;
                    <input type="submit" value="搜 索" class="btn"/>&nbsp;
                    <input type="button" value="重 置" class="btn" onclick="Go('');"/>
                </td>
            </tr>

        </table>
    </form>
    <form method="post">
        <table cellspacing="0" class="tb ls">
            <tr>
                <th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
                <th>昵称</th>
                <th>所属房间</th>
                <th>上线时间</th>
                <th>下线时间</th>
                <th width="100">操作</th>
            </tr>
            @foreach($robots as $robot)
                <tr align="center">
                    <td><input type="checkbox" name="robot_ids[]" value="{{$robot->id}}"/></td>
                    <td align="left">&nbsp;{{$robot->user_name}}</td>
                    <td>{{$robot->room->name}}</td>
                    <td class="px12">{{$robot->up_time}}</td>
                    <td class="px12">{{$robot->end_time}}</td>
                    <td>
                        <a href="{{route('admin.robots.edit', ['robot'=>$robot->id])}}">
                            <img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
                        <a href="?moduleid=2&file=index&action=delete&userid=2"
                           onclick="del({{$robot->id}})"><img
                                    src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
                    </td>
                </tr>
            @endforeach

        </table>

    </form>

    <div >
        {{$robots->links()}}
    </div>
    <script type="text/javascript">Menuon(1);</script>
    <script>
        function del(id) {
            var r=confirm("注意：确定要删除吗?");
            if (r==true)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/robots') }}/"+ id,
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