<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>注册 - {{$site['site_name']}}</title>
    <link rel="stylesheet" href="{{asset('m/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('m/css/m_register.css')}}"/>
    <script src="{{asset('m/js/jquery.min.js')}}"></script>
    <script src="{{asset('m/js/set_of_variables.js')}}"></script>
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
        <span>注册</span>
    </div>
    <div class="register">
        <a href="{{route('main.login')}}">
            登录
        </a>
    </div>
</header>
<main>
    <form action="" id="register_form">
        <div class="yourname_box">
            <span>账号</span>
            <input type="text" id="yournumber"  name="email"  placeholder="请输入你的邮箱"/>
        </div>
        <div class="yourname_box" >
            <span>昵称</span>
            <input id="yourname" type="text" name="name" maxlength="16" />
        </div>
        <div class="yourname_box">
            <span>密码</span>
            <input type="password" id="password" name="password" maxlength="16"/>
        </div>
        <div class="yourname_box">
            <span>确认密码</span>
            <input type="password" id="twopassword" name="password_confirmation" maxlength="16"/>
        </div>
        <div class="yourname_box">
            <span>手机号</span>
            <input type="text" id="phonenumber" name="mobile" maxlength="16"/>
        </div>
        <div class="yourname_box">
            <span>QQ</span>
            <input type="text" id="qqnumber" name="qq"   maxlength="15"/>
        </div>
        <input type="hidden" value="" class="token" name="_token" />
        <input type="hidden" value="1" name="room_id" />
        <div class="ajax_btn">
            <p><input type="button" value="同意协议并注册"/></p>
            <p><span class="userprotocol"><a href="">与用户协议</a></span></p>
        </div>
    </form>
</main>
<footer></footer>
<script>
    // <!--注册成功跳转-->
    var  success_url="m_success.html";
</script>
<script src="{{asset('m/js/m_register.js')}}"></script>
</body>

</html>