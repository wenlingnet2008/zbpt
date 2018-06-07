@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.dash.main') }}" >系统首页</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.dash.password') }}" >修改密码</a></td>
            <td id="Tab2" class="tab"><a href="javascript:Dconfirm('确定要退出管理后台吗?', '{{ route('admin.logout') }}');" >安全退出</a></td></tr>
    </table>
@stop


@section('content')
    @include('admin.flash_error_or_success')
<form method="post" action="{{ route('admin.dash.changepassword') }}" onsubmit="return check();">
    {{csrf_field()}}
    <table cellspacing="0" class="tb">
        <tr>
            <td class="tl"><span class="f_red">*</span> 新登录密码</td>
            <td><input type="password" name="password" size="30" id="password" autocomplete="off"/> <span id="dpassword" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 重复新密码</td>
            <td><input type="password" name="password_confirmation" size="30" id="cpassword" autocomplete="off"/> <span id="dcpassword" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"><span class="f_red">*</span> 现有密码</td>
            <td><input type="password" name="oldpassword" size="30" id="oldpassword" autocomplete="off"/> <span id="doldpassword" class="f_red"></span></td>
        </tr>
        <tr>
            <td class="tl"> </td>
            <td><input type="submit" name="submit" value="修 改" class="btn-g"/></td>
        </tr>
</form>
</table>
<script type="text/javascript">
    function check() {
        var l;
        var f;
        f = 'password';
        l = Dd(f).value.length;
        if(l < 6) {
            Dmsg('新登录密码最少6位，当前已输入'+l+'位', f);
            return false;
        }
        f = 'cpassword';
        l = Dd(f).value;
        if(l != Dd('password').value) {
            Dmsg('重复新密码与新登录密码不一致', f);
            return false;
        }
        f = 'oldpassword';
        l = Dd(f).value.length;
        if(l < 6) {
            Dmsg('现有密码最少6位，当前已输入'+l+'位', f);
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript">Menuon(1);</script>

@stop
