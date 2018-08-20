/**
 * Created by Administrator on 2018/7/31 0031.
 */

$(function(){
    var   reg=/^\w{6,16}$/;
    getToken();
    $("#ajax_btn").on("click",function(){
         if($("#user_name").val().trim() =="" ){
            $(".ajax_btn").find("span").html("用户名不能为空!!!");
            return false;
        }else if($("#user_password").val().trim()!="" && !reg.test($("#user_password").val().trim())){
            $(".ajax_btn").find("span").html("密码格式不正确!!!");
            return false;
        }else if($("#user_password").val().trim() ==""){
            $(".ajax_btn").find("span").html("密码不能为空!!!");
            return false;
        }
        $(".ajax_btn").find("span").html(" ");
        var check=true;
        if (check) {
            $.ajax({
                type: "POST",
                data: $("#login_form").serialize(),
                url: api.login,
                xhrFields: {
                    withCredentials:flag
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
                            $(".ajax_btn").find("span").html(errors.email[0]);
                        }
                        if (errors.mobile) {
                            $(".ajax_btn").find("span").html(errors.mobile[0]);
                        }
                        if (errors.name) {
                            $(".ajax_btn").find("span").html(errors.name[0]);
                        }
                        if (errors.password) {
                            $(".ajax_btn").find("span").html(errors.password[0]);
                        }
                    } else {
                        $(".ajax_btn").find("span").html(msg.message);
                    }
                },
                success: function (data) {
                        //window.location.href=success_url;
                    location.href=document.referrer;
                },
                complete: function () {
                    check = true;
                    getToken();
                }
            })
        }
        return false;
    })
    $("#run_1").on("click",function(){
        window.history.back(-1);
    })


    function getToken() {
        var token = '';
        $.ajax({
            type: "GET",
            data: {},
            url: api.get_token,
            dataType: "json",
            xhrFields: {
                withCredentials: flag
            },
            error: function (data) {
                // getToken();
            },
            success: function (data) {
                token = data._token;
                $(".token").val(token);
                return token;
            }
        })
    }

})
