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
    <form method="post" action="{{ route('admin.robotmessages.store') }}" onsubmit="return Dcheck();">
        {{csrf_field()}}
        <table cellspacing="0" class="tb">

            <tr>
                <td class="tl"><span class="f_hid">*</span>发言内容</td>
                <td>
                    <textarea  name="content"  style="width:500px;height:50px;"></textarea>
                </td>
            </tr>

        </table>


        <div class="sbt"><input type="submit" name="submit" value="确 定" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input
                    type="button" value="取 消" class="btn" onclick="Go('?');"/></div>
    </form>
    <script type="text/javascript">

        function Dcheck() {
            return true;
        }
        Menuon(0);
    </script>


@stop