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
            @foreach($messages as $message)
                <tr align="center">
                    <td align="left">&nbsp;{{$message->user_name}}</td>
                    <td class="px12">{{$message->to_user_name}}</td>
                    <td>{{$message->content}}</td>
                    <td>{{$message->room->name}}</td>
                    <td class="px12">{{$message->created_at}}</td>


                </tr>
            @endforeach

        </table>

    </form>

    <div >
        {{$messages->links()}}
    </div>
    <script type="text/javascript">Menuon(1);</script>

@stop