@extends('layouts.admin.layout')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('/admin/dropify/dist/css/dropify.min.css') }}">
@stop
@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{route('admin.rooms.create')}}">添加房间</a></td>
            <td id="Tab1" class="tab"><a href="{{route('admin.rooms.index')}}">房间列表</a></td>
        </tr>

    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.rooms.store') }}"  enctype="multipart/form-data">
        {{csrf_field()}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 房间名称</td>
                <td><input type="text" size="20" name="room[name]" value="@if(old('room.name')){{old('room.name')}}@endif" />&nbsp;</td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span>Logo</td>
                <td>
                    <div style="width: 120px">
                        <input type="file" id="input-file-now" name='room[logo]' class="dropify"
                               data-height="100" data-max-file-size="2M" data-default-file=""/>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span> 房间状态</td>
                <td>
                    <input type="radio" name="room[open]" value="1" checked  onclick="Ds('dclose');"><label for="status_1"> 开启</label>
                    <input type="radio" name="room[open]" value="0"  onclick="Dh('dclose');"><label for="status_0">  关闭</label>
                </td>
            </tr>

            <tr id="dclose">
                <td class="tl">访问密码</td>
                <td><input type="input" name="room[access_password]" value=""><img src="/admin/image/tips.png" width="16" height="16" title="留空表示无须密码访问" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);"><br/>
                </td>
            </tr>



            <tr>
                <td class="tl"> 可访问的用户组</td>
                <td>
                    <span id="roles_list">
                    @foreach($roles as $k => $role)
                            <input type="checkbox" name="roles[]" value="{{$role->name}}"  id="menu_c_{{$k}}"><label for="menu_c_{{$k}}"> {{ $role->name }}</label>
                        @endforeach
                    </span>
                    <a href="javascript:check_box('roles_list', true);" class="t">全选</a> / <a href="javascript:check_box('roles_list', false);" class="t">全不选</a>
                </td>
            </tr>

            <tr>
                <td class="tl">电脑端代码</td>
                <td><textarea name="room[pc_code]"  style="width:500px;height:100px;overflow:visible;"></textarea><br/>
                </td>
            </tr>

            <tr>
                <td class="tl">手机端代码</td>
                <td><textarea name="room[mobile_code]"  style="width:500px;height:100px;overflow:visible;"></textarea><br/>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 讲师</td>
                <td><select name="room[user_id]" >
                        <option value="">选择讲师</option>
                        @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                        @endforeach
                    </select></td>
            </tr>


            <tr>
                <td class="tl"><span class="f_hid">*</span> 所有者/代理商</td>
                <td><select name="room[owner_id]" >
                        <option value="0">选择代理</option>
                        @foreach($owners as $owner)
                            <option value="{{$owner->id}}">{{$owner->name}}</option>
                        @endforeach
                    </select></td>
            </tr>


            <tr id="dclose">
                <td class="tl">限时时间</td>
                <td><input type="input" name="room[time_limit]" value="0"><img src="/admin/image/tips.png" width="16" height="16" title="限制用户停留房间的时间，留空或者0表示不限制" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);"><br/>
                </td>
            </tr>

            <tr>
                <td class="tl"> 限时用户组</td>
                <td>
                    <span id="limit_groups">
                    @foreach($roles as $k => $role)
                            <input type="checkbox" name="room[limit_groups][]" value="{{$role->name}}"  id="limit_c_{{$k}}"><label for="limit_c_{{$k}}"> {{ $role->name }}</label>
                        @endforeach
                    </span>
                    <a href="javascript:check_box('limit_groups', true);" class="t">全选</a> / <a href="javascript:check_box('limit_groups', false);" class="t">全不选</a><br/>
                    <img src="/admin/image/tips.png" width="16" height="16" title="限时用户组：如果 可访问用户组 无此 用户组， 则限时用户组不起作用" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);">
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span> 机器人</td>
                <td>
                    <input type="radio" name="room[robot_open]" value="1"  onclick="Ds('dclose');"><label for="status_1"> 开启</label>
                    <input type="radio" name="room[robot_open]" value="0" checked onclick="Dh('dclose');"><label for="status_0">  关闭</label>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span> 发言次数限制(每分钟)</td>
                <td><input type="input" name="room[say_limit]" value="60">次<img src="/admin/image/tips.png" width="16" height="16" title="限制用户每分钟的发言次数" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);"><br/>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span> 介绍</td>
                <td><textarea name="room[content]" id="content" class="dsn"></textarea>
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

@stop