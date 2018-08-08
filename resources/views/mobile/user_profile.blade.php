<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>个人信息</title>
    <link rel="stylesheet" href="{{asset('m/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('m/css/m_userdata.css')}}"/>
    <script src="{{asset('m/js/jquery.min.js')}}"></script>
    <script src="{{asset('m/js/bootstrap.min.js')}}"></script>
</head>
<body>
<form action="" id="userdata_form">
    <header>
        <div class="backoff">
            <a href="#">
                <span></span>
            </a>
        </div>
        <div class="center">
            <span>个人信息</span>
        </div>
        <div class="register">
            <a href="javascript:;" id="ajax">
                保存
            </a>
        </div>
    </header>
    <main>
        <div class="top">
        </div>
        <div class="comment_box">
            <ul class="comment_ul">
            </ul>
        </div>
        <div class="changepwd">
            <a href="{{route('user.changepassword')}}"><span>修改密码</span></a>
        </div>
        <div class="loginout">
            <span>退出登录</span>
        </div>
    </main>
</form>
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
        checkOnline: hosturl + 'room_check_onlineroom_check_online',//检查是否在线
        bindlogin: hostsrc + "login",//绑定连接
        say: hostsrc + 'say',//发送消息
        kick: hostsrc + "kick",//踢出房间
        mute: hostsrc + "mute",//禁止发言
        unmute: hostsrc + "unmute",//解除禁止
        getuserinfors: hosturl + 'room_user/',
        sayprivate: hostsrc + 'sayprivate',//私聊
        isLogin: hosturl + 'is_login',//判断用户是否登录
        upuserdata:hosturl+"update_user_profile",
    };
    var to_user_id="all";
    var room_id = '1';
    //没有登录跳转页面地址
    //关于获取token  字段
</script>
<script src="/m/js/m_userdata.js"></script>
</body>
</html>