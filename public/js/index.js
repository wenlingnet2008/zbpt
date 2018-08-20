var privatelsit = [],//私聊用户列表
  robot_id = 'norobot';//机器人id,默认未选
//获取token
function getToken(cb) {
  $.ajax({
    type: "GET",
    data: {},
    url: api.get_token,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
      getToken();
    },
    success: function (data) {
      token = data._token;
      $(".token").val(token);
      cb && cb(token)
      return false;
    }
  })
}
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
          location.href = '/online_error';
          return;
        } else if (data.online == 2) { //ip被限制访问
          location.href = '/firewall';
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
  // console.log(data);
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
        },
        fail: function (res) {
        },
        complete: function (res) {
          var status = res.status;
          if (status == 401) {
            alert(res.responseJSON.message);
          }
        }
      });
      break;
    // 登录 更新用户列表
    case 'login':
      if (data['client_list']) {
        client_list = data['client_list'];
      }
      else {
        if ($.inArray(data['name'], client_list) == -1) {
          client_list[data['user_id']] = data['name'] + '||' + data['roles'][0]['name'];
        }
      }
      flush_client_list();
      recordUsers(data, '加入聊天室');
      break;
    // 发言
    case 'say':
      say(data, data['content']);
      break;
    // 私聊
    case 'say_private':
      say_privates(data, data['content'])
      break;
    // 用户退出 更新用户列表
    case 'logout':
      recordUsers(data, '退出了');
      delete client_list[data['user_id']];
      flush_client_list();
  }
}
// 播报进入、离开用户
function recordUsers(data, msg) {
  var recordmsg = '',
    from_client_name = '';
  if (!data['name'] != undefined) {
    from_client_name = data['name']
  }
  if (data['from_client_name'] != undefined) {
    from_client_name = data['from_client_name']
  }
  recordmsg += '<li class="recordlist">';
  recordmsg += '<span class="recordtxt">' + from_client_name + '&nbsp;' + msg + '&nbsp;' + getTime(data['time']) + '</span>';
  recordmsg += '</li>';
  $(".left_recordBox").prepend(recordmsg);
};

// 刷新用户列表框
function flush_client_list() {
  var userlist_window = $("#onlineuser");
  var client_list_slelect = $("#client_list");
  userlist_window.empty();
  client_list_slelect.empty();
  client_list_slelect.append('<option value="all" id="cli_all">所有人</option>');
  var str = '';
  for (var p in client_list) {
    var name_role = client_list[p],
      arry = name_role.split('||'),
      names = arry[0],
      roles = arry[1];
    str += '  <li class="people">';
    str += '<img src="../imgs/hdefaultuser.png" alt="" class="fl peoplepic">';
    str += '<span class="fl peoplename" data-id="' + p + '">' + names + '</span>';
    if (roles == '管理员') {
      str += '<img src="../imgs/vip4.png" alt="" class="fr peoplevip">';
    } else if (roles == '普通会员') {
      str += '<img src="../imgs/vip1.png" alt="" class="fr peoplevip">';
    } else if (roles == '白银会员') {
      str += '<img src="../imgs/vip2.png" alt="" class="fr peoplevip">';
    } else if (roles == '黄金会员') {
      str += '<img src="../imgs/vip3.png" alt="" class="fr peoplevip">';
    } else if (roles == '游客') {
      str += '<img src="../imgs/vip0.png" alt="" class="fr peoplevip">';
    } else if (roles == '客服') {
      str += '<img src="../imgs/bgservice.png" alt="" class="fr peoplevip">';
    }
    str += '</li>';
    client_list_slelect.append('<option value="' + p + '">' + names + '</option>');
  }
  $("#client_list").val(select_client_id);
  userlist_window.append(str);
  $(".acountnum").text($("#onlineuser li").length);
};
// 获取时分
function getTime(time) {
  var date = new Date(time),
    hour = date.getHours().toString(),
    min = date.getMinutes().toString();
  if (hour.length == 1) {
    hour = '0' + hour
  }
  if (min.length == 1) {
    min = '0' + min
  }
  return hour + ':' + min;
};
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
};
// 主界面发言渲染
function say(data, content) {
  var from_client_id = data['from_client_id'],
    from_client_name = '',
    to_client_id = data['to_client_id'],
    time = data['time'],
    user_id = data['user_id'],
    roles = data['roles'][0],
    rolesname = roles.name;
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
  var arr = content.split('@start');
  var style = '';
  if (arr[1] != undefined) {
    var arr1 = arr[1].split('@end');
    if (arr1[1] != undefined) {
      content = arr[0] + arr1[1];
      style = arr1[0];
    }
  }
  var str = '';
  str += '    <li class="userli">';
  str += '<span class="fl times">' + getTime(time) + '</span>';
  if (rolesname == '管理员') {
    str += '<div class="fl cardindetify vip4"></div>';
  } else if (rolesname == '普通会员') {
    str += '<div class="fl cardindetify vip1"></div>';
  } else if (rolesname == '白银会员') {
    str += '<div class="fl cardindetify vip2"></div>';
  } else if (rolesname == '黄金会员') {
    str += '<div class="fl cardindetify vip3"></div>';
  } else if (rolesname == '客服') {
    str += '<div class="fl cardindetify vip0"></div>';
  } else {
    str += '<div class="fl cardindetify vip1"></div>';
  }
  str += '<span class="fl peoplename" data-id="' + user_id + '">' + from_client_name + '：</span>';
  if (to_client_id != 'all' && to_client_id != undefined) {
    str += '<span class="fl peoplenames"> @ ' + to_client_name + '：</span>';
  }
  str += '<span class="fl peoplemsg" ' + style + '>' + content + ' </span>';
  str += '</li>';
  $("#talkusers").append(str).parseEmotion();
  if (isonBullet) {
    bulletMove(content);
  };
  if (isscroll) {
    $('.talksmain').scrollTop($("#talkusers").height());
  }
};
// 聊天记录
getTodayTalks();
function getTodayTalks() {
  $.ajax({
    type: "GET",
    data: {},
    url: api.getTodayTalks + room_id,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {

    },
    success: function (data) {
      var str = '';
      for (var i in data) {
        let msg = data[i];
        var content = msg['content'],
          from_client_name = msg['user_name'],
          to_client_id = msg['to_user_id'],
          time = msg['created_at'],
          user_id = msg['user_id'],
          roles = msg['user']['roles'][0],
          to_client_name = '',
          rolesname = roles.name;
        if (to_client_id != 0 && to_client_id != undefined) {
          to_client_name = msg['to_user_name'];
        }
        content = html_decode(content);
        var arr = content.split('@start');
        var style = '';
        if (arr[1] != undefined) {
          var arr1 = arr[1].split('@end');
          if (arr1[1] != undefined) {
            content = arr[0] + arr1[1];
            style = arr1[0];
          }
        }
        var str = '';
        str += '    <li class="userli">';
        str += '<span class="fl times">' + getTime(time) + '</span>';
        if (rolesname == '管理员') {
          str += '<div class="fl cardindetify vip4"></div>';
        } else if (rolesname == '普通会员') {
          str += '<div class="fl cardindetify vip1"></div>';
        } else if (rolesname == '白银会员') {
          str += '<div class="fl cardindetify vip2"></div>';
        } else if (rolesname == '黄金会员') {
          str += '<div class="fl cardindetify vip3"></div>';
        } else if (rolesname == '客服') {
          str += '<div class="fl cardindetify vip0"></div>';
        } else {
          str += '<div class="fl cardindetify vip1"></div>';
        }
        str += '<span class="fl peoplename" data-id="' + user_id + '">' + from_client_name + '：</span>';
        if (to_client_id != 0 && to_client_id != undefined) {
          str += '<span class="fl peoplenames"> @ ' + to_client_name + '：</span>';
        }
        str += '<span class="fl peoplemsg" ' + style + '>' + content + ' </span>';
        str += '</li>';
        $("#talkusers").append(str).parseEmotion();
        $('.talksmain').scrollTop($("#talkusers").height());
      }
      var tipstr = '<li class="userli" id="historytip"><i></i><span>以上是历史消息<span><i></i></li>';
      $("#talkusers").append(tipstr);
      $('.talksmain').scrollTop($("#talkusers").height());
    }
  })
};
// 私聊界面发言渲染
function say_privates(data, content) {
  var from_client_id = data['from_client_id'].toString(),
    from_client_name = data['from_client_name'],
    to_client_id = data['to_client_id'],
    to_client_name = data['to_client_name'],
    time = data['time'];
  content = html_decode(content);
  var storage = window.localStorage,
    userid = storage.getItem('userid');
  if (to_client_id == userid) {
    getPrivateList('', '', function () {
      if ($('.mytalkBox').css('display') == 'block') {
        privatelsit.forEach((el, i) => {
          if (from_client_id == el.id) {
            $("#talklist li").eq(i).find('.redcircle').css('display', 'block');
          }
        })
      } else {
        privatelsit.forEach((el, i) => {
          if (from_client_id == el.id) {
            $("#talklist li").eq(i).find('.redcircle').css('display', 'block');
          }
        })
        $("#openmyChat .redcircle").css('display', 'block');
      }
    });
  }
  var str = '';
  if (from_client_id !== userid) {
    str += '  <li class="msgli msgli_left">';
    str += '<img src="../imgs/hdefaultuser.png" alt="" class="bgli">';
    str += '<div class="msg_txts">';
    str += '<div class="liname">' + from_client_name + '</div>';
    str += '<div class="txtword">' + content + '</div>';
    str += '</div>';
    str += '</li>';
  } else if (from_client_id == userid) {
    str += '<li class="msgli msgli_right">';
    str += '<img src="../imgs/hdefaultuser.png" alt="" class="bgli">';
    str += '<div class="msg_txts">';
    str += '<div class="liname"></div>';
    str += '<div class="txtword">' + content + '</div>';
    str += '</div>';
    str += '</li>';
  }
  $("#talkcontent .talksmsg").each(function () {
    if ($(this).css('display') == 'block') {
      $(this).find('.msgBox').append(str).parseEmotion();
      $(this).scrollTop($(this).find('.msgBox').height())
    }
  })
};
// 随机数
function ranDom(m, n) {
  var num = Math.floor(Math.random() * (m - n) + n);
  return num;
};

// 弹幕运动
function bulletMove(bullentmsg) {
  var barrageBoxh = $(".currentVideo").height() - 50,
    width = $(".currentVideo").width() + 200 + 'px',
    toph = ranDom(10, barrageBoxh) + 'px';
  var bullet = $("<span>");
  bullet.html(bullentmsg).parseEmotion();
  bullet.addClass("barragetxt");
  bullet.css("left", width);
  bullet.css("top", toph);
  bullet.animate({
    left: -1000
  }, ranDom(5, 10) * 1000, "linear", function () {
    bullet.remove();
  });
  $(".barrageBox").append(bullet);
};
// abouttalk
$(function () {
  // 弹幕开关
  $(".inputswitch").change(function () {
    isonBullet = !isonBullet;
    if (!isonBullet) {
      $('.switch span').addClass('spanoff');
    } else {
      $('.switch span').removeClass('spanoff');
    }
  });
  $("#client_list").change(function () {
    select_client_id = $("#client_list option:selected").attr("value");
  });
  //主界面表情
  $('.otherSetBox .face').click(function (event) {
    $(this).sinaEmotion();
    $("#sinaEmotion").css("top", "");
    $("#sinaEmotion").css("left", "");
    $("#sinaEmotion").css("bottom", "105px");
    event.stopPropagation();
  });
  // 私聊界面表情
  $('.talkform .face').click(function (event) {
    $(this).sinaEmotion();
    $("#sinaEmotion").css("display", "block");
    $("#sinaEmotion").css("bottom", "290px");
    $("#sinaEmotion").css("left", "26%");
    $("#sinaEmotion").css("top", "");
    event.stopPropagation();
  });

  // 私聊界面列表切换
  $("#talklist").on('click', 'li', function () {
    var index = $(this).index();
    other_userid = $(this).attr('data-id');
    getPrivateSay(other_userid);
    $(this).addClass('active').siblings().removeClass('active');
    $("#talkcontent .talksmsg").eq(index).css('display', 'block').siblings().css('display', 'none');
    $(this).find('.redcircle').css('display', 'none');
  });
  // 私聊发送会话
  $("#toFriend").on("click", function () {
    var content = $('#textarea').val();
    if (!content) {
      alert("发送内容不能为空");
      return false;
    }
    if (!other_userid) {
      alert("请选择聊天用户");
      return false;
    }
    getToken(function () {
      sayPrivate(other_userid, content, token);
    })
  })
  $("#textarea").keydown(function (e) {
    if (e.keyCode == 13) {
      $("#toFriend").click();
      return false;
    }
  });

  $("#bt_caitiao").click(function () {
    $("#caitiao").toggle();
  });
  $(".c_pt dd").click(function () {
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
    $("#caitiao").toggle();
    onSubmit(msg);
  });
  // 提交对话
  $("#submitmsg").click(function () {
    var content = $('#content').val();
    if (!content) {
      alert("发送内容不能为空");
      return false;
    }
    var style = $('#content').attr('style');
    if (style != undefined) {
      content = content + '@startstyle="' + style + '"@end';
    }
    if (robot_id == 'norobot') {
      getToken(function () {
        onSubmit(content, token);
      })
    } else {
      robotsSay(robot_id, content)
    }
  })
  $("#content").keydown(function (e) {
    if (e.keyCode == 13) {
      $("#submitmsg").click();
      return false;
    }
  });
  function onSubmit(msg, token) {
    var input = $("#content");
    var to_user_id = $("#client_list option:selected").attr("value");
    var to_client_name = $("#client_list option:selected").text();
    var inputtxt = $("#content").val().trim();
    $.ajax({
      type: 'POST',
      url: api.say,
      xhrFields: { withCredentials: flag },
      data: {
        to_user_id: to_user_id,
        room_id: room_id,
        content: msg,
        _token: token,
      },
      success: function (data) {
        input.val('');
        input.focus();
      },
      fail: function (res) {

      },
      complete: function (res) {
        var status = res.status;
        if (status == 401) {
          $(".loginFixed").css("display", 'block');
        } else if (status == 400) {
          alert(res.responseJSON.message)
        }
      }
    });
    return false;
  };
  // 右键六个操作
  sixOptions($("#talkusers"));
  sixOptions($("#onlineuser"));
  function sixOptions(obj) {
    obj.on('click', ".right_options .roptionslist", function (e) {
      var type = $(this).attr("data-type");
      if (type == 'talk') {
        $('.mytalkBox').fadeIn();
        getPrivateList(other_userid, other_name);
      } else if (type == 'userinfor') {
        getuserInfors(other_userid, 'right')
      } else if (type == 'kick') {
        kick(other_userid)
      } else if (type == 'mute') {
        mute(other_userid)
      } else if (type == 'unmute') {
        unmute(other_userid)
      }
    })
  };
  // 客服私聊操作
  $("#onlineservice").on('click', ".right_options .roptionslist", function (e) {
    var isonline = $(this).parent().siblings('.peoplename').attr('data-isonline');
    if (isonline == 'false') {
      alert('该客服不在线，请咨询其他在线客服！');
      return false;
    } else {
      $('.mytalkBox').fadeIn();
      getPrivateList(other_userid, other_name);
    }
  })
  // 私聊
  function sayPrivate(touserid, msg, token) {
    var input = $("#textarea");
    $.ajax({
      type: 'POST',
      url: api.sayprivate,
      xhrFields: { withCredentials: flag },
      data: {
        to_user_id: touserid,
        room_id: room_id,
        content: msg,
        _token: token,
      },
      success: function (data) {
        input.val('');
        input.focus();
      },
      fail: function (res) {
        console.log(res);
      },
      complete: function (res) {
        var status = res.status;
        if (status == 401) {

        } else if (status == 400) {
          alert(res.responseJSON.message)
        }
      }
    });
    return false;
  };
  //踢出房间
  function kick(userid) {
    $.ajax({
      type: 'POST',
      url: api.kick,
      xhrFields: { withCredentials: flag },
      data: {
        room_id: room_id,
        user_id: userid,
      },
      success: function (data) {
        console.log(data);
        alert(data.message);
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
  //禁止发言
  function mute(userid) {
    $.ajax({
      type: 'POST',
      url: api.mute,
      xhrFields: { withCredentials: flag },
      data: {
        user_id: userid,
      },
      success: function (data) {
        console.log(data);
        alert(data.message);
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
  // 解除禁止
  function unmute(userid) {
    $.ajax({
      type: 'POST',
      url: api.unmute,
      xhrFields: { withCredentials: flag },
      data: {
        user_id: userid,
      },
      success: function (data) {
        console.log(data);
        alert(data.message);
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
});
// 页面js
calMainHeight()
function calMainHeight() {
  var roboth = 0;
  if ($("#robotBox").css('display') == 'block') {
    roboth = 34;
  }
  var winHeight = $(window).height(),
    winWidth = $(window).width(),
    main = $("#main"),
    talksBox = $(".talksBox"),
    peoples = $(".peoples"),
    mainHeight = winHeight - 59,
    talksBoxh = mainHeight - 30 - 34 - 168 - roboth,
    talksmainh = talksBoxh - 40,
    peoplesh = mainHeight - 497,
    mainw = winWidth - 340 - 254 - 40,
    videoh = mainHeight - 104 - 138;
  centerMax = mainw;
  main.css("height", mainHeight + 'px');
  $('.centerBox').css("width", mainw + 'px');
  talksBox.css("height", talksBoxh + 'px');
  $('.talksmain').css("height", talksmainh + 'px');
  peoples.css("height", peoplesh + 'px');
  $(".currentVideo").css("height", videoh + 'px');
}

$(function () {
  // 计算内容高度
  var centerMax = 0;
  window.onresize = function () {//浏览器窗口改变事件
    calMainHeight();
  }
  autoPlay();
  function autoPlay() {
    var len = $(".marquees li").length;
    if (len > 1) {
      var top_qweqwe = 0, h = 34, ulheight = -len * h;
      time_end = setInterval(function () {
        $(".marquees").animate({
          top: top_qweqwe + "px",
        });
        top_qweqwe -= h;
        if (top_qweqwe <= ulheight) {
          top_qweqwe = 0;
        }
      }, 4000)
    }
  }
  // 左边内容的展开收拢
  $('.leftBtn').click(function () {
    var rw = $(".rightBox").width(),
      step = 174;
    if ($(this).hasClass('leftBtnopen')) {
      $(this).removeClass('leftBtnopen');
      $(".leftContent").animate({
        width: "254px",
      }, 'fast');
      $('.mains .leftBox .navBox .navs:nth-child(3n-1)').css('margin', '20px 22px 0');
      $('.alluserBox').fadeIn();
      $(".rightBox").animate({
        width: rw - step
      }, 'fast');
    } else {

      $(this).addClass('leftBtnopen');
      $(".leftContent").animate({
        width: "80px",
      }, 'fast');
      $('.mains .leftBox .navBox .navs:nth-child(3n-1)').css('margin', '20px 0 0');
      $('.alluserBox').fadeOut();
      $(".rightBox").animate({
        width: rw + step
      }, 'fast');
    }
  });
  // 在线人数与我的客服间切换
  getCustomer();//获取我的客服
  $(".userTap .taptxt").click(function () {
    var index = $(this).index();
    $(this).addClass('taptxta').siblings().removeClass('taptxta');
    if (index == 0) {
      $('.usersBox .onlineusers').css('display', 'block');
      $('.usersBox .myservice').css('display', 'none');
    } else if (index == 1) {
      getCustomer();
      $('.usersBox .onlineusers').css('display', 'none');
      $('.usersBox .myservice').css('display', 'block');
    }
  });
  // 右边导航切换
  $(".main-content-menu li").click(function () {
    var index = $(this).index(),
      $objBox = $(".rightmainBox .rmainBox");
    $(this).addClass("active").siblings().removeClass("active");
    $objBox.eq(index).css("display", "block").siblings().css("display", "none");
    if(index == 1){
      var obj = $('.moneydataiframe');
      addIframe(obj);
    }
    if (index == 3) {
      getRoomTeacher();
    }
  });


  function addIframe(obj){
    var striframe = '';
    striframe += '<iframe scrolling="auto" allowtransparency="true" id="layui-layer-iframe2"';
    striframe += 'name="layui-layer-iframe2" frameborder="0" src="http://rili-d.jin10.com/open.php"';
    striframe += 'style="width:100%;height: 100%;"></iframe>';
    var has = obj.find('iframe');
    if(!has.length){
      obj.append(striframe);
    }
  }

  getRoomTeacher();
  // 获取房间老师
  function getRoomTeacher() {
    $.ajax({
      type: "GET",
      data: {},
      url: api.room_teacher + room_id,
      dataType: "json",
      xhrFields: {
        withCredentials: flag
      },
      error: function (data) {
      },
      success: function (data) {
        if (data.image != null) {
          $(".bgteacher").attr('src', data.image);
        } else {
          $(".bgteacher").attr('src', '../imgs/vip0.png');
        }
        $(".teachername").html(data.name);
        $(".introduce").html(data.introduce);
        $(".acountordernum").html(data.order_num);
        $(".success_ate").html(data.success_rate + '%');
        $(".avg_money").html(data.avg_profit);
      }
    })
  };

  // 弹出左侧导航数据
  $(".navBox li").click(function () {
    var index = $(this).index();
    if (index == 0) {
      $('.moneyDatafixed').fadeIn();
      var obj = $('.moneydataiframe');
      addIframe(obj);
    } else if (index == 1) {
      getOrderes('now', 1);
      $('.ordersFixed').fadeIn();
      $(".ordertab .tabs").eq(0).addClass("tabsactive").siblings().removeClass("tabsactive")
    } else {
      alert('敬请期待！')
    }
  })
  $("#moreservice").click(function () {
    $('.moreServices').fadeIn();
  })
  //我的私聊
  getPrivateList('', '');
  $('#openmyChat').click(function () {
    var len = $('#talklist li').length;
    if(!len){
      other_userid = '';
    }
    $('.mytalkBox').fadeIn();
    $("#openmyChat .redcircle").css('display', 'none');
  })
  var types = '';
  $(".ordertab .tabs").click(function () {
    types = $(this).attr("data-type");
    $(this).addClass("tabsactive").siblings().removeClass("tabsactive");
    getOrderes(types, 1);
  });
  // 获取喊单数据
  function getOrderes(type, page) {
    $.ajax({
      type: "GET",
      data: {},
      url: api.room_orders + room_id + '?type=' + type + '&page=' + page,
      dataType: "json",
      xhrFields: {
        withCredentials: flag
      },
      error: function (data) {
      },
      success: function (data) {
        var msg = data.data,
          len = msg.length,
          total = Math.ceil(data.total),
          per_page = Math.ceil(data.per_page),
          allpage = Math.ceil(total / per_page),
          str = '',
          pagestr = '',
          curpage = 1;
        $("#total").html(total);

        if (len) {
          msg.forEach(el => {
            str += '  <tr>';
            str += '<td>' + el.id + '</td>';
            str += '<td>' + el.created_at + '</td>';
            if (el.doing == 0) {
              str += '<td>做空</td>';
            } else {
              str += '<td>做多</td>';
            }
            str += '<td>' + el.position + '</td>';
            str += '<td>' + el.order_type.name + '</td>';
            str += '<td>' + el.open_price + '</td>';
            str += '<td>' + el.stop_price + '</td>';
            str += '<td>' + el.earn_price + '</td>';
            str += '<td>' + el.updated_at + '</td>';
            str += '<td>' + el.profit_loss + '</td>';
            str += '<td>' + el.user.name + '</td>';
            str += '</tr>';
          });
          $("#orderbody").html(str);
          var options = {
            bootstrapMajorVersion: 4, //版本
            currentPage: curpage, //当前页数
            totalPages: allpage, //总页数
            itemTexts: function (type, page, current) {
              switch (type) {
                case "prev":
                  return "上一页";
                case "next":
                  return "下一页";
                case "page":
                  return page;
              }
            },//点击事件，用于通过Ajax来刷新整个list列表
            onPageClicked: function (event, originalEvent, type, page) {
              if (page != curpage) {
                getOrderes(types, page);
              }
            }
          };
          $('#page').bootstrapPaginator(options);
        } else {
          str = "<tr><td colspan='11'>暂无数据</td></tr>"
          $("#orderbody").html(str);
        }
      }
    })
  };


  // 聊天用户右键事件
  window.oncontextmenu = function (e) {
    e.preventDefault();
  }
  // 生成右键盒子
  function creatRightBox(permission) {
    var str = '';
    str += '<ul class="right_options">';
    for (var key in permission) {
      if (key == 'say_private') {
        str += '<li class="roptionslist" data-type="talk">';
        str += '<img src="../imgs/rtalk.png" alt="" class="fl roptionbg">';
        str += '<span class="fl roptiontxt">私聊</span>';
        str += '</li>';
      } else if (key == 'view_user') {
        str += '<li class="roptionslist" data-type="userinfor">';
        str += '<img src="../imgs/rdata.png" alt="" class="fl roptionbg">';
        str += '<span class="fl roptiontxt">查看资料</span>';
        str += '</li>';
      } else if (key == 'manage_user') {
        str += '<li class="roptionslist" data-type="kick">';
        str += '<img src="../imgs/rout.png" alt="" class="fl roptionbg">';
        str += '<span class="fl roptiontxt">踢出、封IP</span>';
        str += '</li>';
        str += '<li class="roptionslist" data-type="mute">';
        str += '<img src="../imgs/rnospeak.png" alt="" class="fl roptionbg">';
        str += '<span class="fl roptiontxt">禁言</span>';
        str += '</li>';
        str += '<li class="roptionslist" data-type="unmute">';
        str += '<img src="../imgs/rdream.png" alt="" class="fl roptionbg">';
        str += '<span class="fl roptiontxt">解除禁言</span>';
        str += '</li>';
      }
    }
    str += '</ul>';
    return str;
  };
  var permission = {};
  // 获取右键权限菜单
  function rightMenu(userid, cb) {
    $.ajax({
      type: 'POST',
      url: api.permissions,
      xhrFields: { withCredentials: flag },
      data: {
        room_id: room_id,
        to_user_id: userid,
      },
      success: function (data) {
        permission = data.permission;
        cb && cb(permission);
      },
      fail: function (res) {
        console.log(res);
      },
      error: function (res) {
        alert(res.responseJSON.message);
      },
      complete: function (res) {
      }
    });
  };
  $("#talkusers").on('mousedown', ".userli .peoplename", function (e) {
    e.preventDefault();
    var button = e.button;
    var that = $(this);
    if (button == 2) {
      other_userid = that.attr('data-id');
      other_name = that.text().trim();
      other_name = other_name.replace('：','');
      rightMenu(other_userid, function () {
        var str = creatRightBox(permission);
        that.parent().append(str);
        that.siblings(".right_options").toggle();
        that.parent().siblings().children(".right_options").remove();
      });
    } else {
      that.parent().children(".right_options").remove();
    }
  });
  $("body").click(function () {
    $(".right_options").remove();
  });
  // 在线用户的右键事件
  $("#onlineuser").on('mousedown', ".people .peoplename", function (e) {
    e.preventDefault();
    var button = e.button;
    var that = $(this);
    if (button == 2) {
      other_userid = that.attr('data-id');
      other_name = that.text();
      rightMenu(other_userid, function () {
        var str = creatRightBox(permission);
        that.parent().append(str);
        that.siblings(".right_options").toggle();
        that.parent().siblings().children(".right_options").remove();
      });
    } else {
      that.parent().children(".right_options").remove();
    }
  });
  // 在线客服的右键事件
  $("#onlineservice").on('mousedown', ".people .peoplename", function (e) {
    e.preventDefault();
    var button = e.button;
    var that = $(this);
    if (button == 2) {
      other_userid = that.attr('data-id');
      other_name = that.text();
      var str = '';
      str += '<ul class="right_options">';
      str += '<li class="roptionslist" data-type="talk">';
      str += '<img src="../imgs/rtalk.png" alt="" class="fl roptionbg">';
      str += '<span class="fl roptiontxt">私聊</span>';
      str += '</li>';
      str += '</ul>';
      that.parent().append(str);
      that.siblings(".right_options").toggle();
      that.parent().siblings().children(".right_options").remove();
    } else {
      that.parent().children(".right_options").remove();
    }
  });
  // 字体
  $("#bt_font").click(function () {
    $("#FontBar").toggle();
  })
  $("#setcolor").bigColorpicker(function (el, color) {
    $(el).css("background-color", color);
    $('.Msg_input .saywords').css('color', color);
  });

  // 设置字体颜色等
  var isweight = true,
    isitalic = true,
    isunderline = true;
  $('#FontBar input[type=image]').click(function () {
    var index = $(this).index();
    if (index == 2) {
      isweight = !isweight;
      if (!isweight) {
        $('.Msg_input .saywords').css('font-weight', 'bold');
      } else {
        $('.Msg_input .saywords').css('font-weight', 'normal');
      }
    } else if (index == 3) {
      isitalic = !isitalic;
      if (!isitalic) {
        $('.Msg_input .saywords').css('font-style', 'italic');
      } else {
        $('.Msg_input .saywords').css('font-style', 'normal');
      }
    } else if (index == 4) {
      isunderline = !isunderline;
      if (!isunderline) {
        $('.Msg_input .saywords').css('text-decoration', 'underline');
      } else {
        $('.Msg_input .saywords').css('text-decoration', 'none');
      }
    }
  })
  $("#FontBar #FontName").change(function () {
    var val = $(this).val();
    $('.Msg_input .saywords').css('font-family', val);
  })
  $("#FontBar #FontSize").change(function () {
    var val = $(this).val();
    $('.Msg_input .saywords').css('font-size', val);
  })

  // 清屏
  $("#bt_qingping").click(function () {
    $("#talkusers").empty();
  })
  // 聊天内容滚动是否选中
  $("#bt_gundong").click(function () {
    isscroll = !isscroll;
    if (!isscroll) {
      $(this).addClass('bgscrollno')
    } else {
      $(this).removeClass('bgscrollno')
    }
  });
  // 点击搜索在线用户
  $("#toSearchuser").on('click', function () {
    var keyword = $(this).siblings().val().trim();
    if (!keyword) {
      alert('请输入搜索关键字！');
      return false;
    } else {
      getSearchuser(keyword)
    }
  })
  getRobots();//获取机器人
  $("#robots").change(function () {
    robot_id = $(this).find("option:selected").val();
  });
  listenIsover();//监听直播是否结束
});
// 获取用户信息
function getuserInfors(id, type) {
  $.ajax({
    type: "GET",
    data: {},
    url: api.getuserinfors + id,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
    },
    success: function (data) {
      if (type == 'right') {
        $(".otheruserBox").fadeIn();
        if (data.image != null) {
          $(".otheruserBox .bgusers").attr('src', data.image);
        } else {
          $(".otheruserBox .bgusers").attr('src', '../imgs/hdefaultuser.png');
        }
        $(".otheruserBox .user_truename").html(data.name);
        $(".otheruserBox .user_name").html(data.nick_name);
        $('.otheruserBox .user_sign').html(data.introduce);
        $(".otheruserBox .user_qq").html(data.qq);
        $(".otheruserBox .user_onlinetime").html(data.online_total_time);
        $('.otheruserBox .user_creattime').html(data.created_at);
        $(".otheruserBox .user_team").html(data.roles[0].name);
      }
    },
    error: function () {
    }
  })
};

// 私聊列表
function getPrivateList(id, name, cb) {
  var hasin = true;//当前的私聊用户默认在私聊列表里面
  $.ajax({
    type: "POST",
    data: {
      room_id: room_id
    },
    url: api.privat_userlist,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
    },
    success: function (data) {
      $("#talklist").empty();
      $("#talkcontent").empty();
      privatelsit = data;
      len = data.length,
        str = '',
        divstr = '';
      if (len) {
        data.forEach((el, i) => {
          if (id == el.id) {
            str += ' <li class="friend active" data-id="' + el.id + '">';
            divstr += ' <div class="talksmsg" style="display: block">';
            hasin = false;
          } else {
            if (i == 0 && id == '') {
              other_userid = data[0].id;
              str += ' <li class="friend active" data-id="' + el.id + '">';
              divstr += ' <div class="talksmsg" style="display: block">';
            }
            else {
              str += ' <li class="friend" data-id="' + el.id + '">';
              divstr += ' <div class="talksmsg" style="display: none">';
            }
          }
          str += '<img src="../imgs/hdefaultuser.png" alt="" class="fl bgfriend">';
          str += '<span class="fl friendname">' + el.name + '</span>';
          str += '<span class="redcircle"></span>';
          str += '</li>';
          divstr += '<ul class="msgBox">';
          divstr += '</ul>';
          divstr += '</div>';
        });
        $("#talklist").html(str);
        $("#talkcontent").html(divstr);
      }
      if (hasin && id != '') {
        other_userid = id;
        var newstr = '',
          newdivstr = '';
        newstr += ' <li class="friend active" data-id="' + id + '">';
        newstr += '<img src="../imgs/hdefaultuser.png" alt="" class="fl bgfriend">';
        newstr += '<span class="fl friendname">' + name + '</span>';
        newstr += '</li>';
        newdivstr += ' <div class="talksmsg" style="display: block">';
        newdivstr += '<ul class="msgBox">';
        newdivstr += '</ul>';
        newdivstr += '</div>';
        $("#talklist").prepend(newstr);
        $("#talkcontent").prepend(newdivstr);
      }
      getPrivateSay(other_userid);
      cb && cb(data);
    }
  })
}
// 与用户的私聊记录
function getPrivateSay(other_userid) {
  $.ajax({
    type: "POST",
    data: {
      room_id: room_id,
      to_user_id: other_userid,
    },
    url: api.privat_saylist,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
    },
    success: function (data) {
      len = data.length,
        str = '',
        divstr = '';
      if (len) {
        var str = '';
        data.forEach((el, i) => {
          var from_client_id = el['user_id'].toString(),
            from_client_name = el['user_name'],
            to_client_id = el['to_user_id'],
            to_client_name = el['to_user_name'],
            content = html_decode(el['content']),
            storage = window.localStorage,
            userid = storage.getItem('userid');
          if (from_client_id !== userid) {
            str += '  <li class="msgli msgli_left">';
            str += '<img src="../imgs/hdefaultuser.png" alt="" class="bgli">';
            str += '<div class="msg_txts">';
            str += '<div class="liname">' + from_client_name + '</div>';
            str += '<div class="txtword">' + content + '</div>';
            str += '</div>';
            str += '</li>';
          } else if (from_client_id == userid) {
            str += '<li class="msgli msgli_right">';
            str += '<img src="../imgs/hdefaultuser.png" alt="" class="bgli">';
            str += '<div class="msg_txts">';
            str += '<div class="liname"></div>';
            str += '<div class="txtword">' + content + '</div>';
            str += '</div>';
            str += '</li>';
          }
        })
        $("#talkcontent .talksmsg").each(function () {
          if ($(this).css('display') == 'block') {
            $(this).find('.msgBox').html(str).parseEmotion();
            $(this).scrollTop($(this).find(".msgBox").height())
          }
        })
      }
    }
  })
}
// 客服列表
function getCustomer() {
  $.ajax({
    type: "GET",
    data: {},
    url: api.customerService + room_id,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
    },
    success: function (data) {
      var serviceBox = $("#onlineservice");
      serviceBox.empty(),
        len = data.length;
      var str = '';
      if (len) {
        data.forEach(el => {
          str += ' <li class="people">';
          if (el.image != null) {
            str += '<img src="' + el.image + '" alt="" class="fl peoplepic">';
          } else {
            str += '<img src="../imgs/hdefaultuser.png" alt="" class="fl peoplepic">';
          }
          str += '<span class="fl peoplename" data-id="' + el.id + '" data-isonline="' + el.is_online + '">' + el.name + '</span>';
          str += '<img src="../imgs/bgservice.png" alt="" class="fr peoplevip">';
          str += '</li>';
        })
        serviceBox.append(str);
        $(".acountsernum").text($("#onlineservice li").length);
      }
    }
  })
};
//搜索在线用户
function getSearchuser(keyword) {
  $.ajax({
    type: "POST",
    url: api.searchOnlineuser,
    data: { name: keyword, room_id: room_id },
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
      getToken();
    },
    success: function (data) {
      var userlist_window = $("#onlineuser");
      userlist_window.empty();
      str = '';
      for (var p in data) {
        var name_role = data[p],
          arry = name_role.split('||'),
          names = arry[0],
          roles = arry[1];
        str += '  <li class="people">';
        str += '<img src="../imgs/hdefaultuser.png" alt="" class="fl peoplepic">';
        str += '<span class="fl peoplename" data-id="' + p + '">' + names + '</span>';
        if (roles == '管理员') {
          str += '<img src="../imgs/vip4.png" alt="" class="fr peoplevip">';
        } else if (roles == '普通会员') {
          str += '<img src="../imgs/vip1.png" alt="" class="fr peoplevip">';
        } else if (roles == '白银会员') {
          str += '<img src="../imgs/vip2.png" alt="" class="fr peoplevip">';
        } else if (roles == '黄金会员') {
          str += '<img src="../imgs/vip3.png" alt="" class="fr peoplevip">';
        } else if (roles == '游客') {
          str += '<img src="../imgs/vip0.png" alt="" class="fr peoplevip">';
        } else if (roles == '客服') {
          str += '<img src="../imgs/bgservice.png" alt="" class="fr peoplevip">';
        }
        str += '</li>';
      }
      userlist_window.append(str);
    }
  })
};
// 机器人列表
function getRobots() {
  $.ajax({
    type: "GET",
    data: {},
    url: api.robots + room_id,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
    },
    success: function (data) {
      var robotsBox = $("#robots");
      robotsBox.empty(),
        len = data.length;
      if (len) {
        var str = '';
        str += '<option value="norobot">选择机器人</option>';
        $("#robotBox").css('display', 'block');
        data.forEach(el => {
          str += '<option value="' + el.user_id + '">' + el.user_name + '</option>';
        })
        robotsBox.append(str);
      } else {
        $("#robotBox").css('display', 'none');
      }
    },
    complete: function (res) {
      var status = res.status;
      if (status == 400) {
        $("#robotBox").css('display', 'none');
      }
      calMainHeight()
    }
  })
};
// 机器人发言
function robotsSay(robot_id, msg) {
  var input = $("#content");
  $.ajax({
    type: 'POST',
    url: api.robotSay,
    xhrFields: { withCredentials: flag },
    data: {
      user_id: robot_id,
      room_id: room_id,
      content: msg,
    },
    success: function (data) {
      input.val('');
      input.focus();
    },
    fail: function (res) {
      console.log(res);
    },
    complete: function (res) {
      var status = res.status;
      if (status == 401) {
        $(".loginFixed").css("display", 'block');
      } else if (status == 400) {
        alert(res.responseJSON.message)
      }
    }
  });
  return false;
};

var timer = null;
function listenIsover() {
  var date = new Date(),
    endtime = new Date(live_times),
    lefttime = endtime - date;
  if (lefttime > 0) {
    timer = setTimeout(function () {
      listenIsover();
    }, 3000);
  } else {
    if (timer) {
      clearTimeout(timer);
    }
    onLives();
    $(".video").css('display','none');
    $(".liveListBox").css('display','block');
  }
};
//正在直播列表
function onLives(){
  $.ajax({
    type: "GET",
    data: {},
    url: api.roomLives,
    dataType: "json",
    xhrFields: {
      withCredentials: flag
    },
    error: function (data) {
    },
    success: function (data) {
      var liveulBox = $(".liveul");
      liveulBox.empty(),
        len = data.length;
      var str = '';
      if (len) {
        data.forEach(el => {
         str += ' <li class="fl liveli">';
         str += '<a href="'+el.url+'" class="livelist">';
         str += '<div class="liveimgBox">';
         str += '<img src="'+el.image+'" alt="" class="livebg">';
         str += ' <div class="tolive">进入直播</div>';
         str += '</div>';
         str += '<div class="liveInfors">';
         str += '<div class="livename">'+el.name+'</div>';
         str += '<div class="liveabout">';
         str += '<div class="fl liveteacher">'+el.teacher+'</div>';
         str += '<div class="fr liveteacher">'+el.start_time+'</div>';
         str += '</div>';
         str += '</div>';
         str += '</a>';
         str += '</li>';
        })
        liveulBox.append(str);
      }
    }
  })
}
