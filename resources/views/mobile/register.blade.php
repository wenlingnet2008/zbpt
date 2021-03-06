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
            <span>账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</span>
            <input id="yourname" placeholder="请输入账号，4-15位的数字或字母" type="text" name="name" maxlength="16" />
        </div>
        <div class="yourname_box" >
            <span>昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称</span>
            <input type="text" placeholder="请输入昵称" id="username"  name="nick_name" />
        </div>
        <div class="yourname_box" >
            <span>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</span>
            <input type="text" id="yournumber"  name="email"  placeholder="请输入你的邮箱"/>
        </div>
        <div class="yourname_box">
            <span>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码</span>
            <input type="password" id="password" placeholder="请输入密码，6-16位的数字或字母" name="password" maxlength="16"/>
        </div>
        <div class="yourname_box">
            <span>确认密码</span>
            <input type="password" id="twopassword" placeholder="请确认密码" name="password_confirmation" maxlength="16"/>
        </div>
        <div class="yourname_box">
            <span>手&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机</span>
            <input type="text" id="phonenumber" placeholder="请输入手机号码" name="mobile" maxlength="16"/>
        </div>
        <div class="yourname_box">
            <span>QQ</span>
            <input type="text" id="qqnumber" name="qq" placeholder="请输入QQ号码"   maxlength="15"/>
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
    <!--注册成功跳转-->
    var  success_url="{{route('room.index', ['id'=> request()->user() ? request()->user()->room_id : 1])}}";
    //    是否支持跨域；
    var flag = true;//是否携带cookie
    //关于请求路径
    var hosturl = '/',
        hostsrc = "/room/";
    //关于api接口
    var api={
        get_token:hosturl+'get_token',
        register: hosturl + 'register',
        room_teacher: hosturl + 'room_teacher/',
        room_orders: hosturl + 'room_orders/',
        bindlogin: hostsrc + "login",//绑定连接
        getuserinfors: hosturl + 'room_user/',
    };
    var to_user_id="all";
    var room_id = '1';
    //没有登录跳转页面地址
    //关于获取token  字段
</script>
<script src="{{asset('m/js/m_register.js')}}"></script>
<script src="{{asset('m/js/varjs.js')}}"></script>
</body>

</html>