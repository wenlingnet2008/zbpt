<html lang="zh-cn" class="desktop landscape">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="renderer" content="webkit">

    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
    <title>{{$room->name}}</title>
    <meta content="直播系统,财经直播,美原油,期货直播系统，股票，趋势" name="keywords">
    <meta content="" name="description">
    <meta property="qc:admins" content="310104337127367555100637572775">
    <meta name="360-site-verification" content="e9f57ba7ed296be93ddcb05e3a1eabab">
    <link rel="shortcut icon" type="image/x-icon" href="/imgs/icon.ico">
    <link href="{{asset('css/jquery-sinaEmotion-2.1.0.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/jquery.bigcolorpicker.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/login.css')}}"/>
    <link href="{{asset('css/index.css')}}" rel="stylesheet" type="text/css">
</head>

<body onload="connect()">
<header class="headBox">
    <div class="headmain">
        <div class="fl logoBox">
            <img src="/imgs/logo.png" alt="">
        </div>
        <div class="fr userBox">
            <div class="fl optionBox">
                <div class="fl options">
                    <img src="/imgs/hchangeskin.png" alt="" class="fl bgoption">
                    <span class="fl optxt">换肤</span>
                </div>
                <div class="fl options">
                    <img src="/imgs/hsign.png" alt="" class="fl bgoption">
                    <span class="fl optxt">签到</span>
                </div>
            </div>
            <div class="fl loginBox">
                <!-- login -->
                <div class="user_login login" style="display: none;">
                    <img src="/imgs/huser.png" alt="" class="fl bglogin">
                    <span class="fl logintxt" data-type="login">登录</span>
                    <span class="fl logintxt" data-type="register">注册</span>
                </div>
                <!-- logined -->
                <div class="user_login logined" style="display: none;">
                    <img src="/imgs/hdefaultusers.png" alt="" class="fl bguser bgusers">
                    <div class="fl usernames">
                        <span class="username user_name">用户</span>
                        <!-- userinforsBox -->
                        <div class="user_infors">
                            <div class="inforsMain">
                                <div class="infor_top">
                                    <div class="infor_exit">退出</div>
                                    <div class="user_infor">
                                        <img src="/imgs/hdefaultuser.png" alt="" class="bgusers">
                                        <div class="user_names">
                                            <span class="user_name">用户</span>
                                            <span class="viplevel">LV 1</span>
                                        </div>
                                        <div class="user_sign">我的签名</div>
                                    </div>
                                </div>
                                <div class="user_Bottom">
                                    <div class="userNavs">
                                        <div class="fl usernav active">用户资料</div>
                                        <div class="fl usernav">编辑资料</div>
                                        <div class="fl usernav">修改密码</div>
                                    </div>
                                    <div class="user_details">
                                        <div class="detail_box baseInfors">
                                            <ul class="baseInfor">
                                                <li class="baseli">
                                                    <span class="fl baseBt">用户姓名： </span>
                                                    <span class="fl basetxt user_truename">保密 </span>
                                                </li>
                                                <li class="baseli">
                                                    <span class="fl baseBt">QQ： </span>
                                                    <span class="fl basetxt user_qq">85258 </span>
                                                </li>
                                                <li class="baseli">
                                                    <span class="fl baseBt">在线时长： </span>
                                                    <span class="fl basetxt user_onlinetime"></span>
                                                </li>
                                                <li class="baseli">
                                                    <span class="fl baseBt">注册时间： </span>
                                                    <span class="fl basetxt user_creattime"></span>
                                                </li>
                                                <li class="baseli">
                                                    <span class="fl baseBt">用户组： </span>
                                                    <span class="fl basetxt user_team"></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="detail_box editInfors" style="display: none;">
                                            <form action="">
                                                <ul class="baseInfor">
                                                    <li class="baseli">
                                                        <span class="fl baseBt">用户昵称： </span>
                                                        <span class="fl basetxt">
                                <input type="text" name="nickname" autocomplete="off">
                              </span>
                                                    </li>
                                                    <li class="baseli">
                                                        <span class="fl baseBt">用户签名： </span>
                                                        <span class="fl basetxt">
                                <input type="text" name="usersign" autocomplete="off">
                              </span>
                                                    </li>
                                                    <li class="baseli">
                                                        <span class="fl baseBt">联系邮箱： </span>
                                                        <span class="fl basetxt">
                                <input type="text" name="email" autocomplete="off">
                              </span>
                                                    </li>
                                                    <li class="baseli">
                                                        <span class="fl baseBt">联系QQ： </span>
                                                        <span class="fl basetxt">
                                <input type="text" name="qq" autocomplete="off">
                              </span>
                                                    </li>
                                                    <li class="baseli">
                                                        <span class="fl baseBt">联系手机： </span>
                                                        <span class="fl basetxt">
                                <input type="text" name="tel" autocomplete="off">
                              </span>
                                                    </li>
                                                    <li class="baseli">
                                                        <span class="fl baseBt">联系性别： </span>
                                                        <span class="fl basetxt">
                                <select name="sex" id="">
                                  <option value="男">男</option>
                                  <option value="女">女</option>
                                </select>
                              </span>
                                                    </li>

                                                    <li class="baseli">
                                                        <span class="fl baseBt">用户头像： </span>
                                                        <span class="fl basetxt">
                                <img src="/imgs/hdefaultuser.png" alt="" class="fl imgactive">
                                <img src="/imgs/hdefaultuser.png" alt="" class="fl">
                                <img src="/imgs/hdefaultuser.png" alt="" class="fl">
                              </span>
                                                    </li>
                                                </ul>
                                                <input type="button" class="fr savebtn" value="保存">
                                            </form>
                                        </div>
                                        <div class="detail_box editInfors" style="display: none;">
                                            <form action="">
                                                <ul class="baseInfor">
                                                    <li class="baseli">
                                                        <span class="fl baseBt">旧密码： </span>
                                                        <span class="fl basetxt">
                                <input type="password" name="oldpwd" autocomplete="off">
                              </span>
                                                    </li>
                                                    <li class="baseli">
                                                        <span class="fl baseBt">新密码： </span>
                                                        <span class="fl basetxt">
                                <input type="password" name="newpwd" autocomplete="off">
                              </span>
                                                    </li>
                                                    <li class="baseli">
                                                        <span class="fl baseBt">确认密码： </span>
                                                        <span class="fl basetxt">
                                <input type="password" name="config" autocomplete="off">
                              </span>
                                                    </li>
                                                </ul>
                                                <input type="button" class="fr savebtn" value="保存">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
<!-- mains -->
<main class="mains" id="main">
    <!-- leftBox -->
    <div class="fl leftBox">
        <div class="leftContent">
            <ul class="navBox">
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navdigital.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">财经数据</span>
                </li>
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navcalltip.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">喊单提醒</span>
                </li>
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navonline.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">在线答疑</span>
                </li>
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navsave.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">共享文档</span>
                </li>
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navcomment.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">市场评论</span>
                </li>
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navtips.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">交易提示</span>
                </li>
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navclasses.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">课程表</span>
                </li>
                <li class="fl navs">
                    <div class="bgsbox">
                        <img src="/imgs/navdigital.png" alt="" class="nacsbg">
                    </div>
                    <span class="navstxt">讲师榜</span>
                </li>
            </ul>
            <div class="alluserBox">
                <ul class="userTap">
                    <li class="taptxt taptxta">在线人数(<span class="acountnum"></span>)</li>
                    <li class="taptxt">我的客服(<span class="acountsernum"></span>)</li>
                </ul>
                <div class="usersBox">
                    <!-- searchBox -->
                    <div class="searchBox">
                        <input type="text" class="fl input" placeholder="输入关键字">
                        <img src="/imgs/btnserach.png" alt="" class="fr btnsearch" id="toSearchuser">
                    </div>
                    <ul class="peoples onlineusers" id="onlineuser"></ul>
                    <ul class="peoples myservice" id="onlineservice"></ul>
                </div>
                <!-- 播报房间用户进入与退出情况 -->
                <ul class="left_recordBox"></ul>
            </div>
        </div>
        <div class="leftBtn"></div>
    </div>
    <!-- centerBox -->
    <div class="fl centerBox">
        <div class="curentTeachers">
            <div class="fl curteacher">
                <img src="/imgs/vip0.png" alt="" class="fl bgteacher ">
                <div class="fl teacherInfor">
                    <div class="teacher_Name">
                        <span class="teachername"></span>
                    </div>
                    <div class="teacherSign introduce"></div>
                    <div class="teachersNums">
                        <div class="fl"><span class="numbt">喊单数量:</span><span class="numcontent acountordernum"></span>
                        </div>
                        <div class="fl"><span class="numbt">单均盈利:</span><span class="numcontent avg_money"></span></div>
                        <div class="fl"><span class="numbt">成功率:</span><span class="numcontent success_ate"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fr aboutOptions">
                <div class="aboutBtns">
                    <div class="fr abouts aboutteacher">讲 师</div>
                    <div class="fr abouts aboutvideo">视 频</div>
                </div>
                <div class="scaleBoxs">
                    <div class="fr likesBox">
                        <div class="fl liketxt">点赞</div>
                        <div class="fl likenum">166</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="currentVideo">
            <!-- 视频容器 -->
            <div class="video">
                {!! $room->pc_code !!}
            </div>
            <!-- 弹幕容器 -->
            <div class="barrageBox"></div>
            <!-- 弹幕开关 -->
            <div class="switch">
                <label>
                    <span>弹幕</span>
                    <input class="inputswitch" type="checkbox">
                </label>
            </div>
        </div>
        <div class="platTipsBox">
            <div class="fl bgplattip"></div>
            <div class="fl plattips">
                <div class="tiptxt">1、国内平台较多，具备优质的并不多，请选择合法平台</div>
                <div class="tiptxt">2、本直播间只作为交流、学习的平台，若操作建议与您软件报价不一样，请谨慎参考</div>
                <div class="tiptxt">3、请您理性分析，切记带好止损止盈，不骄不躁，把控风险</div>
            </div>
        </div>
    </div>
    <!-- rightBox -->
    <div class="fl rightBox">
        <ul class="main-content-menu">
            <li data-type="hall" class="active">大厅</li>
            <li data-type="news" id="caijin">财经数据</li>
            <li data-type="course" id="kcb">直播教程</li>
            <li data-type="zb_teacher" id="zb_teacher">导师介绍</li>
        </ul>
        <div class="rightmainBox">
            <!-- hall -->
            <div class="rmainBox hall" style="display: block">
                <div class="marqueeBox">
                    <ul class="marquees">
                        <li class="marquee">电脑端观看功能更多！</li>
                        <li class="marquee">请大家文明发言！</li>
                        <li class="marquee">请尽量使用PC端观看！</li>
                    </ul>
                </div>
                <div class="talksBox">
                    <div class="talksmain">
                        <!-- 聊天界面 -->
                        <ul class="users" id="talkusers">
                            @foreach($messages as $message)
                            <li class="userli"><span class="fl times">{{\Carbon\Carbon::parse($message->created_at)->format('H:i')}}</span>
                                <div class="fl cardindetify vip1"></div>
                                <span class="fl peoplename" data-id="{{$message->user_id}}">{{$message->user_name}}</span><span class="fl peoplemsg">
                                    {!! htmlspecialchars_decode(htmlspecialchars_decode($message->content)) !!} </span>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    <div class="talksBtns">
                        <a href="javascript:void(0)" class="fl tools bgscrolled" id="bt_gundong">滚动</a>
                        <a href="javascript:void(0)" class="fl tools bgclear" id="bt_qingping">清屏</a>
                    </div>
                </div>
                <div class="talkOptions">
                    <div id="FontBar" class="setFonts" style="display:none">
                        <select name="FontName" id="FontName">
                            <option value="SimSun" style="font-family: SimSun" selected="selected">宋体</option>
                            <option value="SimHei" style="font-family: SimHei">黑体</option>
                            <option value="KaiTi_GB2312" style="font-family: KaiTi_GB2312">楷体</option>
                            <option value="FangSong_GB23122" style="font-family:FangSong_GB2312">仿宋</option>
                            <option value="Microsoft YaHei" style="font-family: Microsoft YaHei">微软雅黑</option>
                            <option value="Arial">Arial</option>
                            <option value="MS Sans Serif">MS Sans Serif</option>
                            <option value="Wingdings">Wingdings</option>
                        </select>
                        <select name="FontSize" id="FontSize">
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12" selected="selected">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                        </select>
                        <input type="image" class="bt_false" title="粗体" onmouseover="this.className='bt_true'"
                               onmouseout="if(this.value=='false')this.className='bt_false'"
                               src="/imgs/bold.gif" value="false">
                        <input type="image" class="bt_false" title="斜体" onmouseover="this.className='bt_true'"
                               onmouseout="if(this.value=='false')this.className='bt_false'"
                               src="/imgs/Italic.gif" value="false">
                        <input type="image" class="bt_false" title="下划线" onmouseover="this.className='bt_true'"
                               onmouseout="if(this.value=='false')this.className='bt_false'"
                               src="/imgs/underline.gif" value="false">
                        <input name="FontColor" type="image" class="bt_false" title="文字颜色" src="/imgs/color.gif"
                               id="setcolor" value="">

                    </div>

                    <div class="optionsBox">
                        <div id="qqbts" class="onlineservice">
                            <span class="fl">在线客服：</span>
                            <a target="_blank"
                               href="http://wpa.qq.com/msgrd?v=3&amp;uin=2379249728&amp;site=qq&amp;menu=yes"
                               class="fl curservice">老师助理</a>
                            <a class="fr morekf" href="javascript: void(0)" id="moreservice">更多客服&gt;&gt;</a>
                        </div>

                        <!-- 增加机器人start -->
                        <div class="onlineservice" id="robotBox">
                            <span class="fl">机器人：</span>
                            <select class="fl userselect" id="robots"></select>
                        </div>
                        <!-- 增加机器人end -->

                        <div class="shareBar">
                            <div class="fl sharebox privateChat">
                                <a href="javascript:void(0)" class="bar_6 bar" id="openmyChat">我的私聊<span
                                            class="redcircle"></span></a>
                            </div>
                            <div class="fl sharebox screenshot">
                                <a href="javascript:void(0)" class="bar"
                                   onclick="alert('请使用CRTL+ALT+A进行截图，然后在发送框内进行粘贴发送')">截图</a>
                            </div>

                            <div class="fl sharebox box">
                                <span class="name">分享</span>
                                <div class="down">
                                    <div class="downinner">
                                        <p>呼唤小伙伴们前来学习吧</p>
                                        <div class="shdiv fix">
                        <span class="weispan">
                          <a class="jiathis_button_weixin weixin">
                            <span>
                              <i></i>
                            </span>
                          </a>
                        </span>
                                            <a href="http://connect.qq.com/widget/shareqq/index.html?pics=http://www.1234tv.com/http://img.1234tv.com/4,04000ad6aa98.jpg?width=50&amp;height=50&amp;title=%E9%A2%86%E8%88%AA%E8%B4%A2%E7%BB%8F&amp;url=www.teamyophk.com&amp;desc=&amp;summary=www.teamyophk.com-&amp;pics=&amp;site=%E9%A2%86%E8%88%AA%E8%B4%A2%E7%BB%8F"
                                               target="_blank" class="qq"></a>
                                            <a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=www.teamyophk.com"
                                               target="_blank" class="fship"></a>
                                        </div>
                                        <em></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form>
                            <div class="otherSetBox">
                                <select class="fl userselect" id="client_list"></select>
                                <span>
                    <div class="somewords">
                      <a href="javascript:void(0)" class="fl bar" id="bt_font"></a>
                    </div>
                    <div class="somewords">
                      <input type="button" class="fl bar face"
                             style="display: block;border:none;cursor: pointer;"></input>
                    </div>
                    <div class="somewords">
                      <a href="javascript:void(0)" class="fl bar" id="bt_caitiao"></a>
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
                  </span>
                            </div>
                            <div class="Msg_input">
                                <div class="form">
                                    <textarea class="fl input saywords" placeholder="在这里输入发送内容" id="content"></textarea>
                                    <div class="fl input textdiv">
                                        <div class="saywords message"></div>
                                    </div>
                                    <input type="button" id="submitmsg" value="发送" class="fr button">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- moneydata -->
            <div class="rmainBox moneydata" style="display: none">
                <div class="iframemain">
                    <iframe scrolling="auto" allowtransparency="true" id="layui-layer-iframe2"
                            name="layui-layer-iframe2" onload="this.className='';"
                            class="" frameborder="0" src="http://rili-d.jin10.com/open.php"
                            style="width:100%;height: 100%;"></iframe>
                </div>
            </div>
            <!-- videoteach -->
            <div class="rmainBox videoteach" style="display: none">
                <div class="iframemain">
                    <iframe id="new_kcb" src="http://www.teamyophk.com/apps/kcb.php?rid=1001"
                            style="border: 0px; width: 100%; height: 100%;"></iframe>
                </div>
            </div>
            <!-- teachersIntroduce -->
            <div class="rmainBox teachersIntroduce" style="display: none">
                <div class="teacher_introduce">
                    <div class="headsBox">
                        <img src="/imgs/vip0.png" alt="" class="fl teacherpic bgteacher">
                        <div class="fl teacherinfor">
                            <div class="teachername"></div>
                            <div class="teacherlable">专家</div>
                        </div>
                    </div>
                    <div class="introduce"></div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- 登录注册 -->
<div class="fixedBox loginFixed" style="display: none">
    <div class="fixedMain">
        <div class="login_box">
            <div class="login_title">
                <span class="active">登录</span>
                <span>注册</span>
                <b class="close_box fiexdclose" id="closeFixed"></b>
            </div>
            <div class="form_box">
                <div class="login_form">
                    <form id="login_form" action="" method="post">
                        <div class="input_box">
                <span>
                  <i></i>
                </span>
                            <input type="text" name="email"/>
                        </div>
                        <div class="input_box">
                <span>
                  <i></i>
                </span>
                            <input type="password" maxlength="16" name="password" autocomplete="off"/>
                            <input type="hidden" value="" class="roomid" name="room_id"/>
                            <input type="hidden" value="" class="token" name="_token"/>
                        </div>
                        <div class="sub_btn">
                            <input type="button" value="立即登陆" id="login"/>
                        </div>
                        <div class="on_btn">
                            <a href="#" target="_blank">游客体验</a>
                        </div>
                    </form>
                </div>
                <div class="register_form" style="display: none">
                    <form id="register_form" action="" method="post">
                        <div class="input_box">
                            <input type="text" placeholder="请输入您的邮箱" name="email"/>
                        </div>
                        <div class="input_box">
                            <input type="text" placeholder="请输入昵称" name="name"/>
                        </div>
                        <div class="input_box">
                            <input type="password" placeholder="请输入6-16位的数字或字符" name="password"/>
                        </div>
                        <div class="input_box">
                            <input type="password" placeholder="请确认密码" name="password_confirmation"/>
                        </div>
                        <div class="input_box">
                            <input type="text" placeholder="请输入QQ号" name="qq"/>
                        </div>
                        <div class="input_box">
                            <input type="text" placeholder="请输入手机号码" name="mobile"/>
                            <input type="hidden" value="" class="roomid" name="room_id"/>
                            <input type="hidden" value="" class="token" name="_token"/>
                        </div>
                        <div class="sub_btn">
                            <input type="submit" id="register" value="同意协议并注册"/>
                        </div>
                        <div class="on_btn">
                            <a href="#" target="_blank">注册协议</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- 喊单提醒 -->
<div class="fixedBox ordersFixed" style="display: none;">
    <div class="ordersBox">
        <div class="orderTitle">
            <div class="fl ordertab">
                <div class="fl tabs tabsactive" data-type="now">即时</div>
                <div class="fl tabs" data-type="history">历史</div>
            </div>
            <div class="fr fiexdclose">&times;</div>
        </div>
        <div class="dataBox">
            <table class="table table-striped">
                <thead class="thead-light">
                <tr>
                    <th scope="col">单号</th>
                    <th scope="col">开仓时间</th>
                    <th scope="col">类型</th>
                    <th scope="col">仓位</th>
                    <th scope="col">商品</th>
                    <th scope="col">开仓价</th>
                    <th scope="col">止损价</th>
                    <th scope="col">止盈价</th>
                    <th scope="col">平仓时间</th>
                    <th scope="col">盈利点数</th>
                    <th scope="col">分析师</th>
                </tr>
                </thead>
                <tbody id="orderbody"></tbody>
            </table>
        </div>
        <div class="pagesBox">
            <!-- <div class="fr gotoPage">前往
              <input type="text" class="input"> 页
            </div> -->
            <nav class="fr">
                <ul class="pagination" id="page">
                </ul>
            </nav>
            <div class="fr alltotal">共
                <span id="total">0</span>条
            </div>
        </div>
    </div>
</div>
<!-- 财经数据 -->
<div class="fixedBox moneyDatafixed" style="display: none">
    <div class="ordersBox">
        <div class="orderTitle">
            <div class="fl orderbt">财经数据</div>
            <div class="fr fiexdclose">&times;</div>
        </div>
        <div class="iframemain">
            <iframe scrolling="auto" allowtransparency="true" id="layui-layer-iframe2" name="layui-layer-iframe2"
                    onload="this.className='';"
                    class="" frameborder="0" src="http://rili-d.jin10.com/open.php"
                    style="width:100%;height: 100%;"></iframe>
        </div>
    </div>
</div>

<!-- 更多客服 -->
<div class="fixedBox moreServices" style="display: none">
    <div class="ordersBox">
        <div class="orderTitle">
            <div class="fl orderbt">客服列表</div>
            <div class="fr fiexdclose">&times;</div>
        </div>
        <div class="iframemain">
            <iframe scrolling="auto" allowtransparency="true" id="layui-layer-iframe6" name="layui-layer-iframe6"
                    onload="this.className='';"
                    class="" frameborder="0" src="http://www.teamyophk.com/apps/kefu.php?rid=1001"
                    style="width:100%;height: 100%;"></iframe>
        </div>
    </div>
</div>
<!-- 我的私聊 -->
<div class="fixedBox mytalkBox" style="display: none;">
    <div class="ordersBox">
        <div class="talkHead">
            <div class="fl myhead">
                <img src="/imgs/hdefaultuser.png" alt="" class="fl bgusers">
                <span class="fl user_name"></span>
            </div>
            <div class="fr fiexdclose">&times;</div>
        </div>
        <div class="talkmain">
            <div class="fl talklist">
                <!-- 列表框 -->
                <ul class="friends" id="talklist"></ul>
            </div>
            <div class="fl talkcontent">
                <!-- 会话框 -->
                <div id="talkcontent" class="someheight"></div>
                <div class="talkform">
                    <form action="">
                        <div class="somewords">
                            <input type="button" class="fl bar face"></input>
                            <div class="fl bar uploadimg">
                                <input type="file" class="inputimg">
                            </div>
                        </div>
                        <div class="friendmsg">
                            <textarea class="input" placeholder="在这里输入发送内容" id="textarea"></textarea>
                            <div class="nput textdiv">
                                <div class="message"></div>
                            </div>
                            <input type="button" id="toFriend" value="发送" class="button">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 查看资料 -->
<div class="fixedBox otheruserBox" style="display: none">
    <div class="ordersBox">
        <div class="orderTitle">
            <div class="fl orderbt">用户资料</div>
            <div class="fr fiexdclose">&times;</div>
        </div>
        <div class="iframemain">
            <div class="user_infor">
                <img src="/imgs/hdefaultuser.png" alt="" class="bgusers">
                <div class="user_names">
                    <span class="user_name">用户</span>
                    <span class="viplevel">LV 1</span>
                </div>
                <div class="user_sign">我的签名</div>
            </div>
            <div class="detail_box baseInfors">
                <ul class="baseInfor">
                    <li class="baseli">
                        <span class="fl baseBt">用户姓名： </span>
                        <span class="fl basetxt user_truename">保密 </span>
                    </li>
                    <li class="baseli">
                        <span class="fl baseBt">QQ： </span>
                        <span class="fl basetxt user_qq">85258 </span>
                    </li>
                    <li class="baseli">
                        <span class="fl baseBt">在线时长： </span>
                        <span class="fl basetxt user_onlinetime"></span>
                    </li>
                    <li class="baseli">
                        <span class="fl baseBt">注册时间： </span>
                        <span class="fl basetxt user_creattime"></span>
                    </li>
                    <li class="baseli">
                        <span class="fl baseBt">用户组： </span>
                        <span class="fl basetxt user_team"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- 页面所需数据、变量 -->
<script type="text/javascript">
    var hosturl = '/',
        hostsrc = "/room/",
        api = {
            get_token: hosturl + 'get_token',//获取token
            register: hosturl + 'register',//用户注册
            login: hosturl + 'login',//用户登录
            logout: hosturl + 'logout',//退出登录
            room_teacher: hosturl + 'room_teacher/',//获取房间老师
            room_orders: hosturl + 'room_orders/',//喊单数据
            getuserinfors: hosturl + 'room_user/',//获取用户信息
            checkOnline: hosturl + 'room_check_online',//检查是否在线
            isLogin: hosturl + 'is_login',//判断用户是否登录
            customerService: hosturl + 'room_customer_service/',//客服列表
            robots:hosturl+'room_robots/',//机器人列表
            robotSay:hostsrc+'robot_say',//机器人发言
            bindlogin: hostsrc + "login",//绑定连接
            say: hostsrc + 'say',//发送消息
            kick: hostsrc + "kick",//踢出房间
            mute: hostsrc + "mute",//禁止发言
            unmute: hostsrc + "unmute",//解除禁止
            sayprivate: hostsrc + 'sayprivate',//私聊
            permissions: hostsrc + 'permission_menu',//获取右键权限菜单
            privat_userlist: hostsrc + 'private_user_list',//私聊用户列表
            privat_saylist: hostsrc + 'private_say_list',//与私聊用户聊天内容
            searchOnlineuser: hostsrc + 'search_online_user',//搜索房间在线用户
        };
    var flag = true;//是否携带cookie
    var room_id = '{{$room->id}}';//房间id
    var token = '';//用户token
    var select_client_id = 'all';//@聊天对象
    var isscroll = true;//聊天界面默认滚动
    var isonBullet = true;//默认弹幕开起
    var other_userid = '', other_name = ''; //右键事件选中的用户id
</script>


<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/swfobject.js')}}"></script>
<script type="text/javascript" src="{{asset('js/web_socket.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-sinaEmotion-2.1.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-paginator.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.bigcolorpicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/common.js')}}"></script>
<script type="text/javascript" src="{{asset('js/index.js')}}"></script>
</body>

</html>