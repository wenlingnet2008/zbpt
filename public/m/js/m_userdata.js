/**
 * Created by Administrator on 2018/8/3 0003.
 */
    //没有登录跳转页面地址
isLogin();
// 分享
$("body").on("click",".headpng ",function(){
    $("#myModal").modal();
});
$("body").on("click",".headpng ",function(){
    $("#myModal").modal();
});

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
        },
        success: function (data) {
            if (data.is_login) {
                var top = "";
                var rolesname = data.data.roles[0].name;
                var data = data.data;
                var dengji = 4;
                if (rolesname == '管理员') {
                    dengji = 6;
                } else if (rolesname == '普通会员') {
                    dengji = 4;
                } else if (rolesname == '白银会员') {
                    dengji = 3;
                } else if (rolesname == '黄金会员') {
                    dengji = 2;
                } else if (rolesname == '客服') {
                    dengji = 1;
                }
                top = "<div class='headpng'>";
                if (data.image) {
                    top += "<img src='" + data.image + "' alt='头像'/> <input type='hidden' name='image' value='" + data.name + "'/>";
                } else {
                    top += "<img src='../imgs/hdefaultuser.png' alt='头像'/><input name='image' type='hidden' value=''/>";
                }
                top += "</div>" + "<div class='username'>";
                if (data.name) {
                    top += "<h1><input type='text' value='" + data.name + "' name='name'/></h1>";
                } else {
                    top += "<h1><input type='text' value='' name='name'/></h1>";
                }

                top += "<h2><span class='cardindetify' data-type='" + dengji + "'></span></h2>" +
                    "</div>" +
                    "<div class='toleft'><span></span></div>";
                $(".top").html(top);
                var datahtml = "";
                if (data.nick_name) {
                    datahtml += "<li><h1>昵称</h1><input type='text' value='" + data.nick_name + "'name='nick_name' /><div class='toleft'><span></span></div></li>";
                } else {
                    datahtml += "<li><h1>昵称</h1><input type='text' value=''/><div class='toleft' name='nick_name'><span></span></div></li>";
                }
                if (data.mobile) {
                    datahtml += "<li><h1>联系手机</h1><input type='text' value='" + data.mobile + "'  name='mobile'/><div class='toleft'><span></span></div></li>";
                } else {
                    datahtml += "<li><h1>联系手机</h1><input type='text' value=''  name='mobile'/><div class='toleft'><span></span></div></li>";
                }
                if (data.email) {
                    datahtml += "<li><h1>联系邮箱</h1><input type='text' value='" + data.email + "'  name='email'/><div class='toleft'><span></span></div></li>";
                } else {
                    datahtml += "<li><h1>联系邮箱</h1><input type='text' value=''  name='email'/><div class='toleft'><span></span></div></li>";
                }
                if (data.sex) {
                    datahtml += "<li><h1>性别</h1><input type='text' value='" + data.sex + "'  name='sex'/><div class='toleft'><span></span></div></li>";
                } else {
                    datahtml += "<li><h1>性别</h1><input type='text' value=' '  name='sex'/><div class='toleft'><span></span></div></li>";

                }
                if (data.qq) {
                    datahtml += "<li><h1>联系QQ</h1><input type='text' value='" + data.qq + "'  name='qq'/><div class='toleft'><span></span></div></li>";
                } else{
                    datahtml += "<li><h1>联系QQ</h1><input type='text' value=''  name='qq'/><div class='toleft'><span></span></div></li>";
                }
                if (data.autograph) {
                    datahtml += "<li><h1>个性签名</h1><input type='text' value='" + data.autograph + "'  name='autograph'/><div class='toleft'><span></span></div></li>";
                } else {
                    datahtml += "<li><h1>个性签名</h1><input type='text' value=''  name='autograph'/><div class='toleft'><span></span></div></li>";
                }
                $(".comment_ul").html(datahtml);
            }else{
                window.location.href="m_login.html";
            }
        }
    })
};
var token="";


// 退出登录
$(".loginout").click(function () {
    getToken(function () {
        loginOut(token)
    });
})


$(".backoff span").on("click",function(){
    window.history.back(-1);
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
            window.location.href="m_login.html";
        }
    })
};
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