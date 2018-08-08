/**
 * Created by Administrator on 2018/8/7 0007.
 */
$(function(){





    var regemail = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/,
        reg=/^\w{6,16}$/;
    $("#oldpassword").on("blur",function(){
        if($("#oldpassword").val().trim()=="" || !reg.test($("#oldpassword").val().trim())){
            $(this).addClass("error");
            return false;
        }else{
            $(this).removeClass("error");
            return false;
        }
    })
    $("#password").on("blur",function(){
        if($("#password").val().trim()=="" || !reg.test($("#password").val().trim())){
            $(this).addClass("error");
            return false;
        }else{
            $(this).removeClass("error");
            return false;
        }
    })

    $("#twopassword").on("blur",function(){
        if($("#twopassword").val().trim()=="" || !reg.test($("#twopassword").val().trim())){
            $(this).addClass("error");
            return false;
        }else if($("#twopassword").val().trim()!=$("#password").val().trim()){
            $(this).addClass("error");
            return false;
        }else{
            $(this).removeClass("error");
            return false;
        }
    })
    $(".ajax_btn input").on("click",function(){
        var error=true;
        $("main").each(function(){
            $(this).find("input").focus();
        })
        var num=0;
        $(".yourname_box").each(function(){
            if($(this).find("input").hasClass("error")){
                num++;
            }
        })
        if(error && num==0){
            $.ajax({
                type: "POST",
                data: $("#changepwd_form").serialize(),
                xhrFields: {
                    withCredentials: flag
                },
                url: api.changepwd,
                dataType: "json",
                beforeSend: function () {
                    error = false;
                },
                error: function (data) {
                    var msg = data.responseJSON,
                        errors = msg.errors;
                    if (data.status == 422) {
                        alert(msg.message);
                    }else{
                        alert(msg.message);
                    }
                },
                success: function (data) {
                    alert(data.message);
                    getToken(function () {
                        loginOut(token)
                    });
                    window.location.href=success_url;
                },
                complate: function () {
                    error = true;
                }
            })
        }
    })
    //获取token
    getToken();


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
                cb && cb(token);
                return false;
            }
        })
    };

})
