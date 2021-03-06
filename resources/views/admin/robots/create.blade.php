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
    <form method="post" action="{{ route('admin.robots.store') }}" onsubmit="return Dcheck();" enctype="multipart/form-data">
        {{csrf_field()}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 昵称</td>
                <td><input type="text" size="20" name="robot[user_name]" id="username" value="@if(old('robot.user_name')){{old('robot.user_name')}}@endif" />&nbsp;<span
                            id="dusername" class="f_red"></span></td>
            </tr>




            <tr>
                <td class="tl"><span class="f_red">*</span> 所属房间</td>
                <td>
                    <span id="room_list">
                    @foreach($rooms as $k => $room)
                            <input type="checkbox" name="rooms[]" value="{{$room->id}}"  id="menu_c_{{$k}}"><label for="menu_c_{{$k}}"> {{ $room->name }}</label>
                        @endforeach
                    </span>
                    <a href="javascript:check_box('room_list', true);" class="t">全选</a> / <a href="javascript:check_box('room_list', false);" class="t">全不选</a>

                </td>
            </tr>



            <tr>
                <td class="tl"><span class="f_hid">*</span>头像</td>
                <td>
                    <div style="width: 120px">
                        <input type="file" id="input-file-now" name='robot[image]' class="dropify"
                               data-height="100" data-max-file-size="2M" data-default-file=""/>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span>上线时间</td>
                <td>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true" style="width: 200px">
                        <input type="text" name="robot[up_time]" class="form-control" value="@if(old('robot.up_time')){{old('robot.up_time')}}@endif"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span>下线时间</td>
                <td>
                    <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true" style="width: 200px">
                        <input type="text" name="robot[end_time]" class="form-control" value="@if(old('robot.end_time')){{old('robot.end_time')}}@endif"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
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
        Menuon(0);
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