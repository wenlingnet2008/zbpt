/**
 * Created by Administrator on 2018/7/27 0027.
 */

if (typeof console == "undefined") { this.console = { log: function (msg) { } }; }
// 如果浏览器不支持websocket，会使用这个flash自动模拟websocket协议，此过程对开发者透明
WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
// 开启flash的websocket debug
WEB_SOCKET_DEBUG = true;
var ws, name, client_list = {};

// 连接服务端
function connect() {
    // 创建websocket
    ws = new WebSocket("ws://"+document.domain+":7272");
    // 当有消息时根据消息类型显示不同信息
    ws.onmessage = onmessage;
    ws.onclose = function (e) {
        console.log(e);
        console.log("连接关闭，定时重连");
        $.ajax({
            type: 'GET',
            url: api.checkOnline,
            xhrFields: { withCredentials: flag },
            data: {},
            success: function (data) {
                //如果已经在线，则不重新连接，解决一个用户多个客户端同时连接问题
                console.log(data.online);
                if (data.online == 1) { // 一个用户多客户端不允许同时在线
                    location.href = 'http://89.208.255.250/online_error';
                    return;
                } else if (data.online == 2) { //ip被限制访问
                    location.href = 'http://89.208.255.250/firewall';
                    return;
                } else {  //网络问题引起的断开，重新连接
                    connect();
                }
            },
            fail: function (res) {
                console.log(res);
            },
            complete: function (res) {
                console.log(res);
                var status = res.status;
                if (status == 401) {
                    alert(res.responseJSON.message);
                }
            }
        });
    };
    ws.onerror = function () {
        console.log("出现错误");
    };
}


// 服务端发来消息时
function onmessage(e) {
    var data = JSON.parse(e.data);
    console.log(data);
    switch (data['type']) {
        // 服务端ping客户端
        case 'ping':
            ws.send('{"type":"pong"}');
            break;;
        case 'init':
            $.ajax({
                type: 'POST',
                url: api.bindlogin,
                xhrFields: { withCredentials: flag },
                data: {
                    client_id: data.client_id,
                    room_id: room_id,
                },
                success: function (data) {
                    console.log(data);
                },
                fail: function (res) {
                    console.log(res);
                },
                complete: function (res) {
                    console.log(res);
                    var status = res.status;
                    if (status == 401) {
                        alert(res.responseJSON.message);
                    }
                }
            });
            break;
        // 登录 更新用户列表
        case 'login':
            //say(data,data['name'] + ' 加入了聊天室');
            break;
        // 发言
        case 'say':
            //say(data['from_client_id'], data['from_client_name'], data['content'], data['time']);
            say(data,data['content'])

            break;
        // 用户退出 更新用户列表
        case 'logout':
            //say(data, data['name'] + "用户退出")
            return false;

    }




}

// 转义
function html_decode(str) {
    var s = "";
    if (str.length == 0) return "";
    s = str.replace(/&amp;/g, "&");
    s = s.replace(/&lt;/g, "<");
    s = s.replace(/&gt;/g, ">");
    s = s.replace(/&nbsp;/g, " ");
    s = s.replace(/&#39;/g, "\'");
    s = s.replace(/&quot;/g, "\"");
    s = s.replace(/<br\/>/g, "\n");

    return s;
}

// 发言
function say(data, content) {
    var from_client_id = data['from_client_id'],
        from_client_name = '',
        to_client_id = data['to_client_id'],
        time = data['time'],
        user_id = data['user_id'];
    if (to_client_id != 'all' && to_client_id != undefined) {
        var to_client_name = data['to_client_name'];
    }
    if (!data['name'] != undefined) {
        from_client_name = data['name']
    }
    if (data['from_client_name'] != undefined) {
        from_client_name = data['from_client_name']
    }
    if (user_id == undefined) {
        user_id = data['from_client_id'];
    }
    content = html_decode(content);
    var roles = data['roles'][0],
        rolesname = roles.name;
    var dengji=4;
    if (rolesname == '管理员') {
        dengji=6;
    }else if (rolesname == '普通会员') {
        dengji=4;
    }else if (rolesname == '白银会员') {
        dengji=3;
    }else if (rolesname == '黄金会员') {
        dengji=2;
    }else if (rolesname == '客服') {
        dengji=1;
    }
    var html="";
    html="<li class='user'>"+
        "<span class='fl times'>9:20</span>"+
        "<div class='fl cardindetify' data-type="+dengji+"></div>"+
        "<div class='fl peoplename_box'>"+
        "<span class='peoplename'>"+from_client_name+"：</span>"+
        "<span class='peoplemsg'>"+
        content+
        "</span>"+
        "</div>"+
        "</li>";
    $("#talkusers").append(html);
    if (isonBullet) {
        bulletMove(content);
    };
    $('#chat_box').scrollTop($("#talkusers").height());
}
// 随机数
    function ranDom(m, n) {
        var num = Math.floor(Math.random() * (m - n) + n);
        return num;
    };

// 弹幕开关
var isonBullet=true;

$(".barrage_btn span").on("click",function(){
    isonBullet = !isonBullet;
    if(!$(this).hasClass("active")){
        $(this).addClass("active");
    }else{
        $(this).removeClass("active");
    }

})

// 弹幕运动



function bulletMove(bullentmsg) {
    var barrageBoxh = $(".video_box").height() - $(".video_box").height()/8,
        width = $(window).width()+"px",
        toph = ranDom(0, barrageBoxh) + 'px';
    var bullet = $("<span>");
    bullet.html(bullentmsg);
    bullet.addClass("barragetxt");
    bullet.css("left", width);
    bullet.css("bottom", toph);

    bullet.css("color", "rgb(" + Math.round(Math.random() * 255) + "," + Math.round(Math.random() * 255) + "," + Math.round(Math.random() * 255) + ")");
    bullet.animate({
        left: -1000
    }, ranDom(5, 10) * 1000, "linear", function () {
        bullet.remove();
    });
    $(".barrageBoxfather").append(bullet);

};


$(function(){

    // 分享
    $("body").on("click",".modal-backdrop ",function(){
        $("#myModal").modal('hide');
    });
    $("body").on("click",".model_ont ",function(){
        $("#myModal").modal('hide');
    });


//公告
    $("#copy_btn").on("click",function(){
        if($(this).find("span").hasClass("active")){
            $(this).find("span").attr("class","");
            $("#Notice_box").attr("class","active");
            time_fun();
        }else{
            $(this).find("span").attr("class","active");
            $("#Notice_box").attr("class","not_active");
            clearInterval(time_end)
        }
    });

    if($("#Notice_box li").length>=2){
        $("#copy_btn").css('display',"block");
    }else{
        $("#copy_btn").css('display',"none");
    }


    var max_index=$("#Notice_box>ul>li").length-1;
    var top_index=0;
    var top_pos;
    time_fun();
    function time_fun(){
        time_end=setInterval(function(){
            top_pos=parseInt($("#Notice_box>ul>li").css("height"));
            top_index++;
            $("#Notice_box").css("top",-top_index*top_pos+"px");
            if(top_index>=max_index){
                top_index=-1;
            }
        },1500)
    }

    $(".nav>ul").find("li").each(function(){
        $(this).on("click",function(){
            $(this).parent().children().attr("class","");
            $(this).attr("class","active");
            $(".main_comment>ul>li").attr("class","");
            $(".main_comment>ul>li").eq($(this).index()).attr("class","active");
            var tttthg=$(".header_box").height()+$(".nav").height();
            $("iframe").css({
                "height":$(window).height()-tttthg,
                "max-height":$(window).height()-tttthg,
            })
        })
    })


})


$(function(){

//提交尾部
    var tttthg=$(".header_box").height()+$(".nav").height()+$(".teacher_box").height()+$(".title_box").height()+2*$(".input_ajax").height()+2;
    $(".chat_box").css({
        "height":$(window).height()-tttthg,
        "max-height":$(window).height()-tttthg,
    })
    $('.face').click(function (event) {
            $(this).sinaEmotion();
            event.stopPropagation();
            $("#sinaEmotion").attr("style","");
            $("#sinaEmotion").removeAttr("style");
            $("#sinaEmotion").css({
                "left":"-1.8666666667vw",
                "display": "block",
            })
        });
    //提交对话
    $("#bt_caitiao").on("click",function(){
        if($(this).hasClass("active")){
            $("#caitiao").css("display","none");
            $(this).removeClass("active")
        }else{
            $("#caitiao").css("display","block");
            $(this).addClass("active");
        }
        return false;
    })
    $("body").on("click",function(){
        $("#caitiao").css("display","none");
        $("#bt_caitiao").removeClass("active");
    })

    $("#caitiao .c_pt dd").click(function () {
        var index = $(this).index(),
            msg = '';
        if (index == 0) {
            msg = '<img src="../imgs/cdyg.gif" alt="">';
        } else if (index == 1) {
            msg = '<img src="../imgs/czyg.gif" alt="">';
        } else if (index == 2) {
            msg = '<img src="../imgs/cs0.gif" alt=""><img src="../imgs/cs0.gif" alt=""><img src="../imgs/cs6.gif" alt=""><img src="../imgs/cs6.gif" alt=""><img src="../imgs/cgeili_thumb.gif" alt=""><img src="../imgs/cgeili_thumb.gif" alt=""><img src="../imgs/cs1.gif" alt=""><img src="../imgs/cs1.gif" alt="">';
        } else if (index == 3) {
            msg = '<img src="../imgs/czs.gif" alt="">';
        } else if (index == 4) {
            msg = '<img src="../imgs/cxh.gif" alt="">';
        }
        onSubmit(msg);
    });

    // 提交对话
    $("#submitmsg").click(function () {
        var content = $('#textarea').val();
        if (!content) {
            alert("发送内容不能为空");
            return false;
        }
        $('.textdiv .message').html(content).parseEmotion();
        var msg = $('.textdiv').html();
        onSubmit(msg);
        $('#textarea').val("");
        $('.textdiv .message').html("");

    })
    function onSubmit(msg) {
        var input = $("#content");
        var to_user_id = "all";
        var to_client_name = "  ";
        var inputtxt = $("#textarea").val().trim();
        $.ajax({
            type: 'POST',
            url: api.say,
            xhrFields: { withCredentials: flag },
            data: {
                to_user_id: to_user_id,
                room_id: room_id,
                content: msg,
                //_token: token,
            },
            success: function (data) {
                input.val('');
                input.focus();
            },
            fail: function (res) {
                console.log(res);
            },
            complete: function (res) {
                console.log(res);
                var status = res.status;
                if (status == 401) {
                    alert("没有权限，请登陆！");
                    window.location.href=success_url;

                } else if (status == 400) {
                    alert(res.responseJSON.message)
                }
            }
        });
        return false;
    };



//    老师资料渲染

    getRoomTeacher();
    // 获取房间老师
    function getRoomTeacher() {
        var room_id = 1;
        $.ajax({
            type: "GET",
            data: {},
            url: api.room_teacher + room_id,
            dataType: "json",
            xhrFields: { withCredentials: flag },
            error: function (data) {
            },
            success: function (data) {
                $(".img_box img").attr("src",data.image);
                $(".teacher_name").html(data.name);
                $(".teacher_comment_data").html(data.introduce)
            }
        })
    };

});