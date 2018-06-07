@extends('layouts.admin.layout')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('/admin/dropify/dist/css/dropify.min.css') }}">
@stop
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
    <form method="post" action="{{ route('admin.users.update', ['user'=>$user->id]) }}" onsubmit="return Dcheck();" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> Email</td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 登录密码</td>
                <td><input type="password" size="20" name="password" id="password" value=""
                           autocomplete="off"/>&nbsp;<span id="dpassword" class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 重复输入密码</td>
                <td><input type="password" size="20" name="password_confirmation" id="cpassword"
                           autocomplete="off"/>&nbsp;<span id="dcpassword" class="f_red"></span></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 所属组</td>
                <td><select name="role" >
                        <option value="">选择组</option>
                        @foreach($roles as $role)
                            <option value="{{$role->name}}" @if($role->name == $user_role->name) selected @endif>{{$role->name}}</option>
                        @endforeach
                    </select></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 昵称</td>
                <td><input type="text" size="20" name="user[name]" id="name" value="{{$user->name}}"/>&nbsp;<span id="dtruename"
                                                                                                                                                  class="f_red"></span>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span>头像</td>
                <td>
                    <div style="width: 120px">
                        <input type="file" id="input-file-now" name='user[image]' class="dropify"
                               data-height="100" data-max-file-size="2M" data-default-file="{{$user->image}}"/>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span> 手机号码</td>
                <td><input type="text" size="20" name="user[mobile]" id="mobile" value="{{$user->mobile}}"/></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_hid">*</span> 介绍</td>
                <td><textarea name="user[introduce]" id="content" class="dsn">{{$user->introduce}}</textarea>
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
            if (Dd('name').value == '') {
                Dmsg('请填写昵称', 'name');
                return false;
            }

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

@stop