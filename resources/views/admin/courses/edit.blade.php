@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{route('admin.courses.create')}}">添加课程</a></td>
            <td id="Tab1" class="tab"><a href="{{route('admin.courses.index')}}">课程列表</a></td>
        </tr>

    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.courses.update', ['course'=>$course->id]) }}" onsubmit="return Dcheck();" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 课程名称</td>
                <td><input type="text" size="20" name="course[name]" id="name" value="{{$course->name}}" />&nbsp;<span
                            id="dname" class="f_red"></span></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 所属房间</td>
                <td><select name="course[room_id]" >
                        <option value="0">选择房间</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}" @if($course->room_id == $room->id) selected @endif>{{$room->name}}</option>
                        @endforeach
                    </select></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span> 介绍</td>
                <td><textarea name="course[content]" id="content" class="dsn">{{$course->content}}</textarea>
                    <script type="text/javascript">
                        var ModuleID = 5;
                        var DTAdmin = 1;
                        var EDPath = "/admin/editor/fckeditor/";
                        var ABPath = "/admin/editor/fckeditor/";
                        var EDW = "100%";
                        var EDH = "350px";
                        var EDD = "0";
                        var EID = "content";
                        var FCKID = "content";</script>
                    <script type="text/javascript" src="/admin/editor/fckeditor/fckeditor.js"></script>
                    <script type="text/javascript">
                        window.onload = function () {
                            var sBasePath = "/admin/editor/fckeditor/";
                            var oFCKeditor = new FCKeditor("content");
                            oFCKeditor.Width = "100%";
                            oFCKeditor.Height = "350px";
                            oFCKeditor.BasePath = sBasePath;
                            oFCKeditor.ToolbarSet = "Simple";
                            oFCKeditor.ReplaceTextarea();
                        }
                    </script>
                    <script type="text/javascript" src="/admin/editor/fckeditor/init.api.js"></script>
                    <script type="text/javascript" src="{{ asset('/admin/script/editor.js') }}"></script>
                    <br/>

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



@stop