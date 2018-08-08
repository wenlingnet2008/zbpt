
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
};
var regemail = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/,
  regtel = /^[1][3,4,5,7,8][0-9]{9}$/,
  regpwd = /^[a-zA-Z0-9]{6,16}$/;
// login/register/edituserinfors
$(function () {
  $(".roomid").val(room_id);
  $(".logintxt").click(function () {
    var $this = $(this),
      type = $this.attr("data-type");
    $(".login_title").find("span").removeClass("active");
    if (type == 'register') {
      $(".login_form").css("display", "none");
      $(".register_form").css("display", "block");
      $(".login_title span").eq(1).addClass('active');
    } else {
      $(".login_form").css("display", "block");
      $(".register_form").css("display", "none");
      $(".login_title span").eq(0).addClass('active');
    }
    $(".loginFixed").fadeIn();
  });
  $(".fiexdclose").click(function () {
    $(".fixedBox").fadeOut();
  })
  getToken();
  //个人信息盒子导航切换
  $(".userNavs .usernav").click(function () {
    var index = $(this).index();
    $(this).addClass('active').siblings().removeClass('active');
    $(".user_details .detail_box").eq(index).css("display", "block").siblings().css("display", "none");
  })
  //关于登录或者注册切换效果
  if ($(".login_title").find("span").length > 0) {
    $(".login_title").find("span").each(function () {
      $(this).on("click", function () {
        $(this).parent().find("span").removeClass("active");
        $(this).addClass("active");
        $(".form_box").children("div").css("display", "none");
        $(".form_box").children("div").eq($(this).index()).css("display", "block");
      })
    })
  }

  // 注册验证
  $(".form_box input[name='email']").blur(function () {
    var val = $(this).val().trim();
    if (!regemail.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  $(".form_box input[name='name']").blur(function () {
    var val = $(this).val().trim();
    if (!val) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  $(".form_box input[name='password']").blur(function () {
    var val = $(this).val().trim();
    if (!regpwd.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  $("#register_form input[name='password_confirmation']").blur(function () {
    var val = $(this).val().trim(),
      pwd = $("#register_form input[name='password']").val().trim();
    if (val != pwd || !regpwd.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  $(".form_box input[name='mobile']").blur(function () {
    var val = $(this).val().trim();
    if (!regtel.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  // 注册
  $("#register").on('click', function () {
    var check = true;
    $(".register_form input").blur();
    if ($(".register_form input").hasClass("error")) {
      check = false;
    }
    if (check) {
      getToken(function () {
        userRegister()
      });
    }
    return false;
  });
  function userRegister() {
    $.ajax({
      type: "POST",
      data: $("#register_form").serialize(),
      xhrFields: {
        withCredentials: flag
      },
      url: api.register,
      dataType: "json",
      beforeSend: function () {
        check = false;
      },
      error: function (data) {
        var msg = data.responseJSON,
          errors = msg.errors;
        if (data.status == 422) {
          if (errors.email) {
            alert(errors.email[0]);
          }
          if (errors.mobile) {
            alert(errors.mobile[0]);
          }
          if (errors.name) {
            alert(errors.name[0]);
          }
          if (errors.password) {
            alert(errors.password[0]);
          }
        } else {
          alert(msg.message);
        }
      },
      success: function (data) {
        var msg = data.data,
          storage = window.localStorage;
        if (msg) {
          var id = msg.id;
          storage.setItem("userid", id);
          $(".loginBox .user_login ").css("display", 'none').eq(1).css("display", 'block');
          if (msg.image != null) {
            $(".bguser").attr('src', msg.image);
          }
          $(".username").html(msg.name);
        }
        location.reload();
        $(".loginFixed").fadeOut();
        alert(data.message);
      },
      complate: function () {
        check = true;
      }
    })
  };
  // 登录
  $("#login").on('click', function () {
    var check = true;
    $(".login_form input").blur();
    if ($(".login_form input").hasClass("error")) {
      check = false;
    }
    if (check) {
      getToken(function () {
        userLogin()
      });
    }
    return false;
  });
  function userLogin() {
    $.ajax({
      type: "POST",
      data: $("#login_form").serialize(),
      url: api.login,
      xhrFields: {
        withCredentials: flag
      },
      dataType: "json",
      beforeSend: function () {
        check = false;
      },
      error: function (data) {
        var msg = data.responseJSON,
          errors = msg.errors;
        if (data.status == 422) {
          if (errors.email) {
            alert(errors.email[0]);
          }
          if (errors.password) {
            alert(errors.password[0]);
          }
        } else {
          alert(msg.message);
        }
      },
      success: function (data) {
        var msg = data.data,
          storage = window.localStorage;
        if (msg) {
          var id = msg.id;
          storage.setItem("userid", id);
          $(".loginBox .user_login ").css("display", 'none').eq(1).css("display", 'block');
          if (msg.image != null) {
            $(".bguser").attr('src', msg.image);
          }
          $(".user_name").html(msg.name);
          $(".user_sign").html(msg.introduce)
        }
        location.reload();//刷新
        $(".loginFixed").fadeOut();
        alert(data.message);
      },
      complate: function () {
        check = true;
      }
    })
  }
});
// 页面js
$(function () {
  // 判断有无登录
  function isLogin() {
    $.ajax({
      type: "GET",
      data: {},
      url: api.isLogin,
      xhrFields: {
        withCredentials: flag
      },
      dataType: "json",
      error: function (data) {
        alert(data.message);
      },
      success: function (data) {
        var is_login = data.is_login;
        if (is_login) {
          var data = data.data;
          if (data) {
            if (data.image != null) {
              $(".bgusers").attr('src', data.image);
            } else {
              $(".bgusers").attr('src', '../imgs/hdefaultuser.png');
            }
            $(".user_truename").html(data.true_name);
            $(".user_name").html(data.name);
            $('.user_sign').html(data.introduce);
            $(".user_qq").html(data.qq);
            $(".user_onlinetime").html(data.online_total_time);
            $('.user_creattime').html(data.created_at);
            $(".user_team").html(data.roles[0].name);
          }
          $(".loginBox .user_login ").css("display", 'none').eq(1).css("display", 'block');
        } else {
          $(".loginBox .user_login ").css("display", 'none').eq(0).css("display", 'block');
        }
      }
    })
  };
  isLogin();
  // 退出登录
  $(".infor_exit").click(function () {
    getToken(function () {
      loginOut(token)
    });
  })
  function loginOut(token) {
    $.ajax({
      type: "POST",
      data: { _token: token },
      url: api.logout,
      xhrFields: {
        withCredentials: flag
      },
      dataType: "json",
      error: function (data) {
        alert(data.message);
      },
      success: function (data) {
        var storage = window.localStorage;
        storage.removeItem("userid");
        location.reload();
      }
    })
  };
  // 资料编辑
  $(".logined .usernames .username").click(function () {
    $(this).toggleClass('usernamesh');
    $(this).siblings('.user_infors').toggle();
  });
  // 修改密码正则验证  
  $("#editpwd_form input[name='oldpassword']").blur(function () {
    var val = $(this).val().trim();
    if (!regpwd.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  $("#editpwd_form input[name='password']").blur(function () {
    var val = $(this).val().trim();
    if (!regpwd.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  $("#editpwd_form input[name='password_confirmation']").blur(function () {
    var val = $(this).val().trim(),
      pwd = $("#editpwd_form input[name='password']").val().trim();
    if (val != pwd || !regpwd.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  // 修改密码保存
  $("#savepwd").on('click', function () {
    var check = true;
    $("#editpwd_form input").blur();
    if ($("#editpwd_form input").hasClass("error")) {
      check = false;
    }
    if (check) {
      getToken(function () {
        editPwd()
      });
    }
    return false;
  });
  function editPwd() {
    $.ajax({
      type: "POST",
      data: $("#editpwd_form").serialize(),
      url: api.editpassword,
      xhrFields: {
        withCredentials: flag
      },
      dataType: "json",
      beforeSend: function () {
        check = false;
      },
      error: function (data) {
        var msg = data.responseJSON;
        alert(msg.message);
      },
      success: function (data) {
        alert(data.message);
        $('.logined .usernames .user_infors').toggle();
        $("#editpwd_form input").val('');
        $(".logined .savebtn").val('保存');
      },
      complate: function () {
        check = true;
      }
    })
  }
  // 编辑资料正则
  
  $("#editinfors_form input[name='qq']").blur(function () {
    var val = $(this).val().trim(),
      regqq = /[1-9][0-9]{4,14}/;
    if (!regqq.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  $("#editinfors_form input[name='mobile']").blur(function () {
    var val = $(this).val().trim();
    if (!regtel.test(val)) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }
  });
  // 选择头像
  var objimg = '';
  $(".basehead img").click(function(){
    $(this).addClass('imgactive').siblings().removeClass('imgactive');
    var src = $(this).attr('src');
    $('.userimgs').val(src);
  });
  $(".selectimage").on('change',function(){
    objimg=$(this)[0].files[0];
    if(objimg){
        var reader = new FileReader();
        var testmsg = objimg.name.substring(objimg.name.lastIndexOf(".") + 1),
            extension = testmsg === "jpg",
            extension2 = testmsg === "png",
            isLt2M = objimg.size / 1024 / 1024 < 10;
        if ((extension || extension2) && isLt2M) {
          $(".selectBox img").attr('src',URL.createObjectURL($(this)[0].files[0]));
        }else{
            alert("只能上传JPG/PNG格式，图片不能超过10M");
            return false;
        }
    }
  })
  // 编辑资料保存
  $("#saveInfors").on('click', function () {
    var check = true;
    $("#editinfors_form input").blur();
    if ($("#editinfors_form input").hasClass("error")) {
      check = false;
    }
    var formdatas = new FormData();
    var data =  $("#editinfors_form").serialize();
    data = data.split('&');
    data.forEach(el => {
      el = el.split('=');
      formdatas.append(el[0],el[1]);
    });
    formdatas.append('image',objimg);
    if (check) {
      getToken(function () {
        editProfile(formdatas)
      });
    }
    return false;
  });
  function editProfile(formdatas) {
    $.ajax({
      type: "POST",
      data:formdatas,
      url: api.editprofile,
      xhrFields: {
        withCredentials: flag
      },
      contentType: false,
      processData: false,
      dataType: "json",
      beforeSend: function () {
        check = false;
      },
      error: function (data) {
        var msg = data.responseJSON;
        alert(msg.message);
      },
      success: function (data) {
        alert(data.message);
        $('.logined .usernames .user_infors').toggle();
        var data = data.data;
        if (data) {
          if (data.image != null) {
            $(".bgusers").attr('src', data.image);
          } else {
            $(".bgusers").attr('src', '../imgs/hdefaultuser.png');
          }
          $(".user_qq").html(data.qq);
        }
        $("#editinfors_form input").val('');
      },
      complate: function () {
        check = true;
      }
    })
  }
});

