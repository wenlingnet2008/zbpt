@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab1" class="tab"><a href="{{route('admin.message.index')}}">消息列表</a></td>
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

                <th>发言人</th>
                <th>接收人</th>
                <th>内容</th>
                <th>所属房间</th>
                <th>发言时间</th>

            </tr>
            <tbody id="new_list">

            </tbody>
            @foreach($messages as $message)
                <tr align="center">
                    <td align="left">&nbsp;{{$message->user_name}}</td>
                    <td class="px12">{{$message->to_user_name}}</td>
                    <td>
                     @php
                            $message->content = strip_tags(htmlspecialchars_decode(htmlspecialchars_decode($message->content)));
                            $message->content = preg_replace("/@start.*?@end/", '', $message->content);
                     @endphp
                        {{$message->content}}
                    </td>
                    <td>{{$message->room->name ?? ''}}</td>
                    <td class="px12">{{$message->created_at}}</td>
                </tr>
            @endforeach

            <input type="hidden" value="{{$messages->first()->id ?? ''}}" id="new">

        </table>

    </form>

    <div >
        {{$messages->links()}}
    </div>
    <script type="text/javascript">Menuon(1);</script>

    <script type="text/javascript">
        window.setInterval(function(){
            var new_id = $("#new").val();
            $.ajax({
            url: '{{route('admin.message.new')}}',
            data: {id:new_id},
            dataType: 'json',
            success: function(res) {

                for(var r in res.data){
                    $("#new_list").prepend(
                        '<tr align="center"> ' +
                        '<td align="left">&nbsp;' + res.data[r].user_name + '</td>' +
                        ' <td class="px12">' + res.data[r].to_user_name + '</td> ' +
                        '<td>' + res.data[r].content + '</td> ' +
                        '<td>' + res.data[r].room.name + '</td> ' +
                        '<td class="px12">' + res.data[r].created_at + '</td>' +
                        ' </tr>'
                    );
                    $("#new").val(res.data[r].id);
                }
            }
        })},5000);

    </script>


@stop