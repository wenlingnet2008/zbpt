<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>登录 - {{$site['site_name']}}</title>
    <link rel="stylesheet" href="{{asset('m/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('m/css/m_login.css')}}"/>
    <script src="{{asset('m/js/jquery.min.js')}}"></script>
    <script src="{{asset('m/js/bootstrap.min.js')}}"></script>
</head>
<body>
<header>
    <div class="backoff">
        <a href="javascript:;" id="run_1">
            <span></span>
        </a>
    </div>
    <div class="center">
        <span>登录</span>
    </div>
    <div class="register">
        <a href="{{route('main.register')}}">
            注册
        </a>
    </div>
</header>
<main>
    <form id="login_form" action="">
        <div class="comment_box user_name">
            <span><i></i></span>
            <input type="text" id="user_name" name="name" placeholder="请输入账号"/>
        </div>
        <div class="comment_box user_password">
            <span><i></i></span>
            <input type="password" maxlength="16" id="user_password" name="password" placeholder="请输入密码"/>
        </div>
        <div class="comment_box ajax_btn">
            <span></span>
            <i><a href="#">忘记密码?</a></i>
            <input type="button" id="ajax_btn" value="登录"/>
        </div>
        <input type="hidden" value="" class="token" name="_token" />
    </form>
</main>
<footer></footer>
<script>
    //    是否支持跨域；
    var flag = true;//是否携带cookie
    //关于请求路径
    var hosturl = '/',
        hostsrc = "/room/";
    //关于api接口
    var api={
        login: hosturl + 'login',
        get_token:hosturl+'get_token',
        register: hosturl + 'register',
        logout: hosturl + 'logout',
        room_teacher: hosturl + 'room_teacher/',
        room_orders: hosturl + 'room_orders/',
        checkOnline: hosturl + 'room_check_online',//检查是否在线
        bindlogin: hostsrc + "login",//绑定连接
        getuserinfors: hosturl + 'room_user/',
    };
    var to_user_id="all";
    var room_id = '1';
    //没有登录跳转页面地址
    //关于获取token  字段
</script>
<script src="{{asset('m/js/m_login.js')}}"></script>
<script src="{{asset('m/js/varjs.js')}}"></script>
</body>
</html>