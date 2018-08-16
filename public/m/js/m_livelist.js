/**
 * Created by Administrator on 2018/8/3 0003.
 */

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

// 判断有无登录

var flag=true;
isLogin();

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
            if(data.is_login){
                var html="";
                var img="";
                if(data.data.image){
                    img=" <img src="+data.data.image+" alt=''/>";
                }else{
                    img=" <img src='../imgs/big_bgcolor.jpg' alt=''/>";
                }
                html="<a href='"+login_yes+"'>"+
                    img+
                    "</a>";

            }else{
                var html="";
                html="<a href='"+login_no+"'>"+
                    "<span>登录</span>"+
                    "</a>";
            }
            $(".login_box").html(html);
        }
    })
};