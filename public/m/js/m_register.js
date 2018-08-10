/**
 * Created by Administrator on 2018/7/31 0031.
 */
$(function(){


    var regemail = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/,
        reg=/^\w{6,16}$/;
    var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
    var regqq=/^[1][0-9]{4,10}$/;
    $(".yourname_box").each(function(){
        $(this).find("input").on("focus",function(){
            $(this).removeClass("error")
        })
    })



    $("#yourname").on("blur",function(){
        if($("#yourname").val().trim()==""){
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

    $("#phonenumber").on("blur",function(){
        if($("#phonenumber").val().trim()=="" || !myreg.test($("#phonenumber").val().trim())){
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
        $(".yourname_box").each(function(){
            if($(this).find("input").hasClass("error")){
                error=false;
            }
        })
        if(error){
            $.ajax({
                type: "POST",
                data: $("#register_form").serialize(),
                xhrFields: {
                    withCredentials: flag
                },
                url: api.register,
                dataType: "json",
                beforeSend: function () {
                    error = false;
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
                    alert(data.message);
                    window.location.href=success_url;
                },
                complate: function () {
                    error = true;
                }
            })
        }
    })

    $("#run_1").on("click",function(){
        window.history.back(-1);
    })

    $(".backoff span").on("click",function(){
        window.history.back(-1);
    })
    getToken()
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
