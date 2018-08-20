<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>{{$room->name}}</title>
    <link rel="stylesheet" href="{{asset('m/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('m/css/m_live.css')}}"/>
    <link rel="stylesheet" href="{{asset('m/css/jquery-sinaEmotion-2.1.0.min.css')}}"/>
    <script src="{{asset('m/js/jquery.min.js')}}"></script>
    <script src="{{asset('m/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('m/js/jquery-sinaEmotion-2.1.0.min.js')}}"></script>
    <script src="{{asset('m/js/web_socket.js')}}"></script>
</head>

<body onload="connect()">
<header>
    <div class="header_box">
        <div class="video_box">
            {!! $room->mobile_code !!}
        </div>
        <div class="return_btn">
            <span></span>
        </div>
        <div class="share_btn" data-toggle="modal" data-target="#myModal">
            <span></span>
        </div>
        <!--<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">开始演示模态框</button>-->
        <div class="barrage_btn">
            <span class="active"></span>
        </div>
        <div class="barrage_box">
            <div class="barrageBoxfather">

            </div>
        </div>
    </div>
</header>
<main>
    <div class="nav">
        <ul>
            <li class="active">大厅</li>
            <li>导师</li>
            <li>财经数据</li>
            <li>直播教程</li>
        </ul>
    </div>
    <div class="main_comment">
        <ul class="comment_box">
            <li class="active">
                <div class="teacher_box">
                    <div class="img_box">
                        <img src="/m/imgs/hdefaultuser.png" alt=""/>
                    </div>

                    <div class="teacher_data">
                        <h3>
                            <span class="teacher_name">方正老师</span>
                            <span class="teacher_god">
                                    <i>点赞数：</i>
                                    <i>688</i>
                                </span>
                        </h3>
                        <div class="teacher_comment">
                            <p>
                                资深专家
                            </p>
                        </div>
                    </div>
                    <div class="barrage_btn">
                    </div>
                </div>
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
                <div class="chat_box" id="chat_box">
                    <div class="talksBox">
                        <div class="talksmain">
                            <ul class="users" id="talkusers">
                                @foreach($messages as $message)
                                <li class="user"><span class="fl times">{{\Carbon\Carbon::parse($message->created_at)->format('H:i')}}</span>
                                    <div class="fl cardindetify" data-type="4"></div>
                                    <div class="fl peoplename_box"><span class="peoplename">{{$message->user_name}}：</span><span
                                                class="peoplemsg">{!! htmlspecialchars_decode(htmlspecialchars_decode($message->content)) !!}</span></div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <!--<div class="talksBtns">-->
                        <!--<a href="javascript:void(0)" class="fl tools bgscrolled" id="bt_gundong" select="true" onclick="bt_toggleScroll()">滚动</a>-->
                        <!--<a href="javascript:void(0)" class="fl tools bgclear" id="bt_qingping" onclick="bt_MsgClear();">清屏</a>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="input_ajax">
                    <form>
                        <div class="fldd expression_box">
                            <input id="face" type="button" class="expression_png face"/>
                            <div id="sinaEmotion" class="sinaEmotion">
                                <div class="right">
                                    <a href="#" class="prev">«</a>
                                    <a href="#" class="next">»</a>
                                </div>
                                <ul class="categories"></ul>
                                <ul class="faces"></ul>
                                <ul class="pages"></ul>
                            </div>
                        </div>
                        <div class="fldd ribbon_box">
                                <span class="ribbon_png" id="bt_caitiao">
                                </span>
                            <div id="caitiao" class="hid ption_a" style="display: none">
                                <dl class="c_pt">
                                    <dd>顶一个</dd>
                                    <dd>赞一个</dd>
                                    <dd>给力</dd>
                                    <dd>掌声</dd>
                                    <dd>鲜花</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="fldd input_box">
                            <textarea class="textarea" name="" id="textarea" cols="30" rows="1"></textarea>

                        </div>
                        <div class="fldd sun_box">
                            <input id="submitmsg" type="button" value="提交"/>
                        </div>

                    </form>
                </div>

            </li>
            <li>
                <div class="teacher_box">
                    <div class="img_box">
                        <img src="/m/imgs/hdefaultuser.png" alt=""/>
                    </div>

                    <div class="teacher_data">
                        <h3>
                            <span class="teacher_name">方正老师</span>
                            <span class="teacher_god">
                                    <i>点赞数：</i>
                                    <i>688</i>
                                </span>
                        </h3>
                        <div class="teacher_comment">
                            <p>
                                资深专家
                            </p>
                        </div>
                    </div>
                    <div class="barrage_btn">
                        <span>点赞</span>
                    </div>
                </div>
                <div class="teacher_comment_data">
                    资料
                </div>
            </li>
            <li id="jin10">

            </li>
            <li>
                <!--<iframe id="new_kcb" src="http://www.teamyophk.com/apps/kcb.php?rid=1001"
                        style="border: 0px; width: 100%; height: 100%;"></iframe>-->
            </li>
        </ul>
    </div>

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <h3>分享到</h3>
                <div class="share_box">
                    <div class="imgco_box">
                        <a target="_blank"
                           href="https://connect.qq.com/widget/shareqq/index.html?pics=http://www.1234tv.com/http://img.1234tv.com/4,04000ad6aa98.jpg?width=50&amp;height=50&amp;title=%E9%A2%86%E8%88%AA%E8%B4%A2%E7%BB%8F&amp;url=www.teamyophk.com&amp;desc=&amp;summary=www.teamyophk.com-&amp;pics=&amp;site=%E9%A2%86%E8%88%AA%E8%B4%A2%E7%BB%8F">
                            <div class="img_box"></div>
                            <h3>QQ</h3>
                        </a>
                    </div>
                    <div class="imgco_box">
                        <a target="_blank" href="#">
                            <div class="img_box"></div>
                            <h3>微信</h3>
                        </a>
                    </div>
                    <div class="imgco_box">
                        <a target="_blank"
                           href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=www.teamyophk.com">
                            <div class="img_box"></div>
                            <h3>空间</h3>
                        </a>
                    </div>
                    <div class="imgco_box">
                        <a target="_blank"
                           href="http://service.weibo.com/share/share.php?spm=a2h28.8313475.player.dp_wb&appkey=2684493555&url=www.teamyophk.com">
                            <div class="img_box"></div>
                            <h3>微博</h3>
                        </a>
                    </div>
                </div>
                <div class="model_ont">
                    取消
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <div class="is_login" id="is_login"></div>

    <div class="end_live">
        <h1 class="end_title">
            <span class="title_icon"></span>
            直播结束，看看其他直播吧
        </h1>
        <div class="new_live">

        </div>
        <div class="new_livefooter">
            <a href="/">返回首页</a>
        </div>
    </div>
</main>
<footer></footer>
</body>
<script>
    //
    <!--没有登录跳转-->
    var success_url = "{{route('main.login')}}";

    //    是否支持跨域；
    var flag = true;//是否携带cookie
    //关于请求路径
    var hosturl = '/',
        hostsrc = "/room/";
    //关于api接口
    var api = {
        login: hosturl + 'login',
        get_token: hosturl + 'get_token',
        register: hosturl + 'register',
        logout: hosturl + 'logout',
        room_teacher: hosturl + 'room_teacher/',
        room_orders: hosturl + 'room_orders/',
        checkOnline: hosturl + 'room_check_online',//检查是否在线
        bindlogin: hostsrc + "login",//绑定连接
        say: hostsrc + 'say',//发送消息
        getuserinfors: hosturl + 'room_user/',
        isLogin: hosturl + 'is_login',//判断用户是否登录
        oldmessage:hosturl+"room_today_message/",
    };
    var live_times = '{{$live->end_time}}';//直播结束时间
    var to_user_id = "all";
    var room_id = '{{$room->id}}';
    //没有登录跳转页面地址
    //关于获取token  字段
</script>
<script src="{{asset('m/js/m_live.js')}}"></script>
<!---->
</html>