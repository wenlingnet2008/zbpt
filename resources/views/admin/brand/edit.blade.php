@extends('layouts.admin.layout')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('/admin/dropify/dist/css/dropify.min.css') }}">
@stop
@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.brands.create') }}">添加品牌</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.brands.index') }}">管理品牌</a></td>
        </tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.brands.update', ['brandid'=>$brand['brandid']]) }}" id="dform" onsubmit="return check();" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 品牌名称</td>
                <td><input name="name" type="text" size="30" value="{{ $brand->name }}" id="name"/><br/><span id="dname"
                                                                                            class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_hid">*</span> 详细说明</td>
                <td>
                    <textarea name="content" id="content" class="dsn">{{ $brand->content }}</textarea>
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
                    <span id="dcontent" class="f_red"></span>
                </td>
            </tr>
            <tr>
                <td class="tl"><span class="f_hid">*</span> Logo</td>
                <td>
                    <div style="width: 120px">
                        <input type="file" id="input-file-now" name='thumb' class="dropify"
                               data-height="100" data-max-file-size="2M" data-default-file="{{ asset($brand->thumb['thumb1']) }}"/>
                    </div>
                </td>
            </tr>
        </table>
        <div class="sbt"><input type="submit" name="submit" value="更新" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input
                    type="button" value="取 消" class="btn" onclick="Go('?');"/></div>

    </form>

    <script type="text/javascript">Menuon(0);</script>

    <script type="text/javascript">
        function check() {
            if (Dd('name').value == '') {
                Dmsg('请填写名称', 'name');
                return false;
            }
            return true;
        }
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
