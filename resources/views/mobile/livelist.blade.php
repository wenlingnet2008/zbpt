<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>直播列表 -  {{$site['site_name']}}</title>
    <link rel="stylesheet" href="{{asset('m/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('m/css/m_livelist.css')}}"/>
    <script src="{{asset('m/js/jquery.min.js')}}"></script>
</head>
<body>
<header>
    <div class="logo_box">
        <a href="{{route('main.index')}}">
            <img src="/m/imgs/newlogo.png" alt="logo"/>
        </a>
    </div>
    <div class="input_box">
        <form action="">
            <input type="text" placeholder="{{$site['site_name']}}"/>
            <span class="search_png"></span>
            <input type="submit" style="display:none;"/>
        </form>
    </div>
    <div class="login_box">
        <a href="#">
            <!--<span>-->
            <!--登录-->
            <!--</span>-->
            <img src="/m/imgs/big_bgcolor.jpg" alt=""/>
        </a>
    </div>
</header>
<main>
    <div class="title_box">
        <div class="active" id="Notice_box">
            <ul>
                <li><a href="#"><span class="icon_horn"></span><span>电脑端观看功能更多！</span></a></li>
                <li><a href="#"><span class="icon_horn"></span><span>请尽量使用电脑观看！</span></a></li>
                <li><a href="#"><span class="icon_horn"></span><span>请大家文明发言！</span></a></li>
            </ul>
        </div>

        <div class="copy_btn" id="copy_btn">
            <span class=""></span>
        </div>
    </div>
    <div class="comment_box">
        <div class="comment_title">
            全部直播
        </div>
        <ul class="comment_ul">
            @foreach($livelists as $livelist)
            <li @if(!$livelist->onlive)
                class="not_live"
                @endif
            >
                <a @if($livelist->onlive)
                   href="{{route('room.index', ['id'=>$livelist->room_id])}}"
                   @endif>
                    <div class="live_logo">
                        <span></span>
                        <i>
                            @if($livelist->onlive)
                                直播中
                            @else
                                直播还未开始
                            @endif
                            </i>
                    </div>
                    <div class="img_box">
                        <img src="/storage/{{$livelist->image}}" alt=""/>
                    </div>
                    <div class="teacher_tet">
                            <span>
                                {{$livelist->room->teacher->name ?? ''}}
                            </span>
                        <span></span>
                    </div>
                    <div class="title_text">
                        <h1>{{$livelist->name}}</h1>
                        <h3>直播时间：<span>{{$livelist->start_time}}</span></h3>

                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</main>
<footer></footer>
<script>
    // <!--没有登录跳转-->
    var  login_no="{{route('main.login')}}";
    var  login_yes="{{route('user.profile')}}";

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
<script src="{{asset('m/js/m_livelist.js')}}"></script>
<script src="{{asset('m/js/varjs.js')}}"></script>
{!! $site['copyright'] !!}
</body>
</html>