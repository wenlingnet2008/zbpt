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
                    top += "<img class='userpng' src='" + data.image + "' alt='头像'/> <input name='image' id='image' type='file' accept='image/gif, image/jpeg, image/png' />";
                } else {
                    top += "<img src='../imgs/hdefaultuser.png' alt='头像'/><input name='image' id='image' type='file' accept='image/gif, image/jpeg, image/png' />";
                }
                top += "</div>" + "<div class='username'>";
                if (data.name) {
                    top += "<h1><input type='text' disabled value='" + data.nick_name + "' name='name'/></h1>";
                } else {
                    top += "<h1><input type='text' value='' name='name'/></h1>";
                }
                top += "<h2><span class='cardindetify' data-type='" + dengji + "'></span></h2>" +
                    "</div>" +
                    "<div class='toleft'><span></span></div>";
                $(".top").html(top);
                var datahtml = "";
                if (data.nick_name) {
                    datahtml += "<li><h1>昵称</h1><input type='text' name='nick_name' value='" + data.nick_name + " '/><div class='toleft'><span></span></div></li>";
                } else {
                    datahtml += "<li><h1>昵称</h1><input type='text' name='nick_name' value=''/><div class='toleft'><span></span></div></li>";
                }
                if (data.mobile) {
                    datahtml += "<li><h1>联系手机</h1><input type='text' id='datamobile' value='" + data.mobile + "'  name='mobile'/><div class='toleft'><span></span></div></li>";
                } else {
                    datahtml += "<li><h1>联系手机</h1><input type='text' id='datamobile' value=''  name='mobile'/><div class='toleft'><span></span></div></li>";
                }
                if (data.email) {
                    datahtml += "<li><h1>联系邮箱</h1><input type='text' disabled value='" + data.email + "' /></li>";
                } else {
                    datahtml += "<li><h1>联系邮箱</h1><input type='text' disabled value='' /></li>";
                }
                //if (data.sex) {
                //    datahtml += "<li><h1>性别</h1><input type='text' value='" + data.sex + "'  name='sex'/><div class='toleft'><span></span></div></li>";
                //} else {
                //    datahtml += "<li><h1>性别</h1><input type='text' value=' '  name='sex'/><div class='toleft'><span></span></div></li>";
                //}
                if (data.qq) {
                    datahtml += "<li><h1>联系QQ</h1><input type='text' id='dataqq' value='" + data.qq + "'  name='qq'/><div class='toleft'><span></span></div></li>";
                } else{
                    datahtml += "<li><h1>联系QQ</h1><input type='text' id='dataqq' value=''  name='qq'/><div class='toleft'><span></span></div></li>";
                }
                //if (data.autograph) {
                //    datahtml += "<li><h1>个性签名</h1><input type='text' value='" + data.autograph + "'  name='autograph'/> <input type='hidden' class='_token' value=''  name='token'/><div class='toleft'><span></span></div></li>";
                //} else {
                //    datahtml += "<li><h1>个性签名</h1><input type='text' value=''  name='autograph'/> <input class='token' type='hidden' value=''  name='_token'/><div class='toleft'><span></span></div></li>";
                //}
                $(".comment_ul").html(datahtml);
                $(".comment_box").append("<input type='hidden' class='token' id='token' value=''  name='token'/>");
                getToken();
            }else{
                window.location.href="/m/login";
            }
        }
    })
};
var token="";
var flag=true;
var check=true;
// 退出登录
$(".loginout").click(function () {
    getToken(function () {
        loginOut(token)
    });
})

var yesuserpng=false;
//-------------------------------关于头像的更改-----------------------------------
$("#userdata_form").on("change","#image",function(){
    var ImgFile = $(this)[0].files[0];
    if(ImgFile){
        var reader = new FileReader();
        var testmsg = ImgFile.name.substring(ImgFile.name.lastIndexOf(".") + 1),
            extension = testmsg === "jpg",
            extension2 = testmsg === "png",
            isLt2M = ImgFile.size / 1024 / 1024 < 10;
        if ((extension || extension2) && isLt2M) {
            var self = $(this);
            reader.readAsDataURL(ImgFile);
            reader.onload = function () {
                self.parent().find("img").attr("src",this.result)
            }
            yesuserpng=true;
        }else{
            alert("只能上传JPG/PNG格式，图片不能超过10M");
            return false;
        }
    }
})


$(".backoff span").on("click",function(){
    window.history.back(-1);
})



$("#ajax").on("click",function(){
    var formdata = new FormData();
    formdata.append("mobile",$("#datamobile").val().trim());
    formdata.append("qq",$("#dataqq").val().trim());
    formdata.append("_token",$("#token").val().trim());
    formdata.append("nick_name",$("input[name='nick_name']").val().trim());
    if(yesuserpng){
      var   FileObj = document.getElementById( "image" ).files[0];
            formdata.append("image",FileObj);
    }
    if(check){
        getToken(function(){
            $.ajax({
                type: "POST",
                data: formdata,
                url: api.upuserdata,
                xhrFields: {
                    withCredentials:flag
                },
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    check = false;
                },
                error: function (data) {
                    var msg = data.responseJSON,
                        errors = msg.errors;
                    if (data.status == 422) {
                        for(var key in errors){
                            alert(errors[key][0]);
                        }
                    } else {
                        alert(msg.message);
                    }
                    check = true
                },
                success: function (data) {
                    alert(data.message);
                    //window.location.href=success_url;
                    //window.location.reload();
                },
                complete: function () {
                    check = true;
                }
            })
        })

    }
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
            window.location.href="/";
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
            $("#token").val(token);
            cb && cb(token);
        }
    })
};