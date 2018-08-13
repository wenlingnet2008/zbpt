@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{route('admin.users.create')}}">添加会员</a></td>
            <td id="Tab1" class="tab"><a href="{{route('admin.users.index')}}">会员列表</a></td>
        </tr>

    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form action="{{route('admin.users.search')}}" method="get">
        <table cellspacing="0" class="tb">
            <tr>
                <td>&nbsp;
                    <select name="fields">
                        @foreach($show_fields as $id => $value)
                            <option value="{{$id}}" @if(request('fields') == $id) selected @endif>{{$value}}</option>
                        @endforeach

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
                <th>会员名</th>
                <th>Email</th>
                <th>手机</th>
                <th>所属组</th>
                <th>所属房间</th>
                <th>注册时间</th>
                <th width="100">操作</th>
            </tr>
            @foreach($users as $user)
            <tr align="center">
                <td><input type="checkbox" name="userid[]" value="{{$user->id}}"/></td>
                <td align="left">&nbsp;{{$user->name}}</td>
                <td class="px12">{{$user->email}}</td>
                <td>{{$user->mobile}}</td>
                <td>{{$user->roles->first()->name ?? ''}}</td>
                <td>@if($user->room){{$user->room->name}} @endif</td>
                <td class="px12">{{$user->created_at}}</td>

                <td>
                    <a href="{{route('admin.users.edit', ['user'=>$user->id])}}">
                        <img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
                    <a href="#"
                       onclick="del({{$user->id}})"><img
                                src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
                </td>
            </tr>
            @endforeach

        </table>

    </form>

    <div >
        {{$users->appends(['fields' => request()->fields, 'kw' => request()->kw, 'psize' => request()->psize])->links()}}
    </div>
    <script type="text/javascript">Menuon(1);</script>

    <script>
        function del(id) {
            var r=confirm("注意：确定要删除吗?");
            if (r==true)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/users') }}/"+ id,
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