@extends('layouts.admin.layout')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('/admin/dropify/dist/css/dropify.min.css') }}">
@stop
@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{route('admin.livelists.create')}}">添加直播</a></td>
            <td id="Tab1" class="tab"><a href="{{route('admin.livelists.index')}}">直播列表</a></td>
        </tr>

    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.livelists.update', ['livelist'=>$live->id]) }}" onsubmit="return Dcheck();" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 直播名称</td>
                <td><input type="text" size="20" name="live[name]" id="name" value="{{$live->name}}" />&nbsp;<span
                            id="dname" class="f_red"></span></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 所属房间</td>
                <td><select name="live[room_id]" >
                        <option value="0">选择房间</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}" @if($live->room_id == $room->id) selected @endif>{{$room->name}}</option>
                        @endforeach
                    </select></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span>图</td>
                <td>
                    <div style="width: 120px">
                        <input type="file" id="input-file-now" name='live[image]' class="dropify"
                               data-height="100" data-max-file-size="2M" data-default-file="/storage/{{$live->image}}"/>
                    </div>
                </td>
            </tr>


            <tr>
                <td>直播开始时间</td>
                <td><input type="text" size="20" name="live[start_time]" id="start_time" value="{{$live->start_time}}" />&nbsp;</td>
            </tr>

            <tr>
                <td>直播结束时间</td>
                <td><input type="text" size="20" name="live[end_time]" id="end_time" value="{{$live->end_time}}" />&nbsp;</td>
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

    <script src="{{asset('/admin/laydate/laydate.js')}}"></script>

    <script>
        laydate.render({
            elem: '#start_time',
            type: 'datetime'
        });
        laydate.render({
            elem: '#end_time',
            type: 'datetime'
        });
    </script>


@stop