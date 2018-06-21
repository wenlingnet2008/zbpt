@extends('layouts.admin.layout')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('/admin/dropify/dist/css/dropify.min.css') }}">
    <!-- Color picker plugins css -->
    <link href="{{ asset('/admin/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
@stop
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
    <form method="post" action="{{ route('admin.robots.update', ['robot'=>$robot->id]) }}" onsubmit="return Dcheck();" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 昵称</td>
                <td><input type="text" size="20" name="robot[user_name]" id="username" value="{{$robot->user_name}}" />&nbsp;<span
                            id="dusername" class="f_red"></span></td>
            </tr>




            <tr>
                <td class="tl"><span class="f_red">*</span> 所属房间</td>
                <td><select name="robot[room_id]" >
                        <option value="">选择房间</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}" @if($room->id == $robot->room_id) selected @endif>{{$room->name}}</option>
                        @endforeach
                    </select></td>
            </tr>



            <tr>
                <td class="tl"><span class="f_hid">*</span>头像</td>
                <td>
                    <div style="width: 120px">
                        <input type="file" id="input-file-now" name='robot[image]' class="dropify"
                               data-height="100" data-max-file-size="2M" data-default-file="{{$robot->image}}"/>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span>上线时间</td>
                <td>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true" style="width: 200px">
                        <input type="text" name="robot[up_time]" class="form-control" value="{{$robot->up_time}}"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span>下线时间</td>
                <td>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true" style="width: 200px">
                        <input type="text" name="robot[end_time]" class="form-control" value="{{$robot->end_time}}"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                    </div>
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
        Menuon(1);
    </script>


    <!-- jQuery file upload -->
    <script src="{{ asset('/admin/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Basic
            $('.dropify').dropify({
                messages: {
                    'default': '点击或拖拽文件到这里',
                    'replace': '点击或拖拽文件到这里来替换文件',
                    'remove': '移除文件',
                    'error': '对不起，你上传的文件太大了',
                }
            });
        });
    </script>

    <!-- Clock Plugin JavaScript -->
    <script src="{{ asset('/admin/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
    <script>
        $('.clockpicker').clockpicker({
            donetext: 'Done',
        }).find('input').change(function() {
            console.log(this.value);
        });

    </script>

@stop