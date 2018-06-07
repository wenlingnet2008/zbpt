@extends('layouts.admin.layout')
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('/admin/dropify/dist/css/dropify.min.css') }}">
@stop
@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab_on"><a href="{{ route('admin.siteconfig') }}" >基本设置</a></td>
        </tr>
    </table>
@stop


@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.siteconfig.update') }}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div id="Tabs0" style="display:">
            <table cellspacing="0" class="tb">
                <tr>
                    <td class="tl">网站名称</td>
                    <td><input name="setting[site_name]" type="text" value="{{ $site_configs['site_name'] }}" size="40"/></td>
                </tr>
                <tr>
                    <td class="tl">网站标题</td>
                    <td><input name="setting[site_title]" type="text" value="{{ $site_configs['site_title'] }}" size="40"/> </td>
                </tr>
                <tr>
                    <td class="tl">网站描述</td>
                    <td><textarea name="setting[site_desc]"  style="width:500px;height:50px;">{{ $site_configs['site_desc'] }}</textarea><br/>
                    </td>
                </tr>
                <tr>
                    <td class="tl">网站LOGO</td>
                    <td>
                        <div style="width: 120px">
                            <input type="file" id="input-file-now" name='logo' class="dropify"
                                   data-height="100" data-max-file-size="2M" data-default-file="{{ $site_configs['logo'] }}"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="tl">版权信息</td>
                    <td><textarea name="setting[copyright]"  style="width:500px;height:50px;">{{ $site_configs['copyright'] }}</textarea><br/>
                    </td>
                </tr>

                <tr>
                    <td class="tl">联系我们</td>
                    <td><textarea name="setting[contact_us]"  style="width:500px;height:50px;">{{ $site_configs['contact_us'] }}</textarea><br/>
                    </td>
                </tr>

                <tr>
                    <td class="tl">关于我们</td>
                    <td><textarea name="setting[about_us]" style="width:500px;height:50px;">{{ $site_configs['about_us'] }}</textarea><br/>
                    </td>
                </tr>


                <tr>
                    <td class="tl">网站状态</td>
                    <td>
                        <input type="radio" name="setting[close]" value="0"  @if(!$site_configs['close']) checked @endif onclick="Dh('dclose');"/> 开启&nbsp;&nbsp;
                        <input type="radio" name="setting[close]" value="1"  @if($site_configs['close']) checked @endif onclick="Ds('dclose');"/> 关闭
                    </td>
                </tr>
                <tr id="dclose" style="@if(!$site_configs['close']) display:none @endif">
                    <td class="tl">关闭原因</td>
                    <td><textarea name="setting[close_reason]" id="close_reason" style="width:500px;height:50px;overflow:visible;">{{ $site_configs['close_reason'] }}</textarea><br/>
                    </td>
                </tr>

                <tr>
                    <td class="tl">新用户注册</td>
                    <td>
                        <input type="radio" name="setting[colse_register]" value="0"  @if(!$site_configs['colse_register']) checked @endif /> 开启&nbsp;&nbsp;
                        <input type="radio" name="setting[colse_register]" value="1"  @if($site_configs['colse_register']) checked @endif /> 关闭
                    </td>
                </tr>

            </table>
        </div>
        <div class="sbt">
            <input type="submit" name="submit" value="保 存" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;

        </div>

    </form>


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