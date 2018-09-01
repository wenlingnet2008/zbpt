<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>修改密码</title>
    <link rel="stylesheet" href="{{asset('m/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('m/css/m_register.css')}}"/>
    <script src="{{asset('m/js/jquery.min.js')}}"></script>
    <script src="{{asset('m/js/bootstrap.min.js')}}"></script>
</head>
<body>
<header>
    <div class="backoff">
        <a href="javascript:;">
            <span></span>
        </a>
    </div>
    <div class="center">
        <span>修改密码</span>
    </div>
    <div class="register">
    </div>
</header>
<main>
    <form action="" id="changepwd_form">
        <div class="yourname_box">
            <span>旧密码</span>
            <input type="password" id="oldpassword"  name="oldpassword"  placeholder="请输入你的旧密码"/>
        </div>
        <div class="yourname_box">
            <span>密码</span>
            <input type="password" id="password" name="password" maxlength="16"/>
        </div>
        <div class="yourname_box">
            <span>确认密码</span>
            <input type="password" id="twopassword" name="password_confirmation" maxlength="16"/>
        </div>
        <input type="hidden" value="" class="token" name="_token" />
        <input type="hidden" value="1" name="room_id" />
        <div class="ajax_btn">
            <p><input type="button" value="提交"/></p>
        </div>
    </form>
</main>
<script>
    //修改成功跳转页面
    var success_url="{{route('user.profile')}}";
    //    是否支持跨域；
    var flag = true;//是否携带cookie
    //关于请求路径
    var hosturl = '/';
    //关于api接口
    var api={
        changepwd:hosturl+"update_user_password",
        get_token:hosturl+'get_token',
    };
</script>
<script src="/m/js/m_changepwd.js"></script>
<script src="{{asset('m/js/varjs.js')}}"></script>
</body>
</html>