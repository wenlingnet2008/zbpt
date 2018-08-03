<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <script src="{{asset('m/js/html-size-calculation.js')}}"></script>
    <link rel="stylesheet" href="{{asset('m/css/swiper.css')}}" />
    <link rel="stylesheet" href="{{asset('m/css/m_index.css')}}" />
    <script src="{{asset('m/js/swiper.min.js')}}"></script>
    <script src="{{asset('m/js/zepto_1.1.3.js')}}"></script>
    <script src="{{asset('m/js/jquery-1.11.3.min.js')}}"></script>
    <title>{{$site['site_name']}}</title>
</head>
<body class="bgf8 hd-fixed ft-fixed">
<header class="mzub fz32 cff header">
    <h2 class="tx-c plr10 mzub-te mzub-f1">

        {{$site['site_name']}}
    </h2>
</header>
<!--轮播 begin-->
<div class="banner">
    <div class="bs-wrapper banner-wrapper">
        <div class="bs-slide banner-slide">
            <a href="#">
                <img src="/m/imgs/banner_1.png" />
            </a>
        </div>
        <div class="bs-slide banner-slide">
            <a href="#">
                <img src="/m/imgs/banner_2.png" />
            </a>
        </div>
        <div class="bs-slide banner-slide">
            <a href="#">
                <img src="/m/imgs/banner_3.png" />
            </a>
        </div>
    </div>
    <div class="banner-pagination"></div>
</div>
<nav class="index-nav clear bgff pb30 pt20">
    <a href="#" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">财经日历</b>
    </a>
    <a href="{{route('main.roomlist')}}" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">直播</b>
    </a>
    <a href="#" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">行情</b>
    </a>
    <a href="#" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">投资策略</b>
    </a>
    <a href="#" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">财经咨询</b>
    </a>
    <a href="#" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">黄金圈</b>
    </a>
    <a href="#" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">会员中心</b>
    </a>
    <a href="#" class="mzub mzub-ver mzub-pc mzub-ac">
				<span class="index-nav-icon-span">
					<i class="index-nav-icon"></i>
				</span>
        <b class="db fz24 c0b0 lh1 mzub-te">关于我们</b>
    </a>
</nav>
<!--<div class="bgff mt20  bgc">-->
<!--<div class="plr30 ptb20 mzub mzub-ac">-->
<!--<b class="fz28 c0b0 pl5">行情</b>-->
<!--<a class="fz12 c8c8 mzub-ac-aa"  href="#">更多</a>-->
<!--</div>-->
<!--<nav class="hangqing">-->
<!--<ul class="clear clear-ul">-->
<!--<li class="clear-box">-->
<!--<a href="#" class="">-->
<!--<h3 class="h3_1">美元指数</h3>-->
<!--<h4 class="h4_1">90.03</h4>-->
<!--<h5 class="h5_1"><span>+0.14%</span><span>+0.3</span></h5>-->
<!--</a>-->
<!--</li>-->
<!--<li class="clear-box">-->
<!--<a href="#" class="">-->
<!--<h3 class="h3_1">美元指数</h3>-->
<!--<h4 class="h4_1">90.03</h4>-->
<!--<h5 class="h5_2"><span>+0.14%</span><span>+0.3</span></h5>-->
<!--</a>-->
<!--</li>-->
<!--<li class="clear-box">-->
<!--<a href="#" class="">-->
<!--<h3 class="h3_1">美元指数</h3>-->
<!--<h4 class="h4_1">90.03</h4>-->
<!--<h5 class="h5_1"><span>+0.14%</span><span>+0.3</span></h5>-->
<!--</a>-->
<!--</li>-->
<!--<li class="clear-box">-->
<!--<a href="#" class="">-->
<!--<h3 class="h3_1">美元指数</h3>-->
<!--<h4 class="h4_1">90.03</h4>-->
<!--<h5 class="h5_1"><span>+0.14%</span><span>+0.3</span></h5>-->
<!--</a>-->
<!--</li>-->
<!--</ul>-->
<!--</nav>-->
<!--</div>-->
<div class="bgff mt16 ">
    <div class="plr30 ptb20 mzub mzub-ac">
        <b class="fz28 c0b0 pl5" id="caijin">财经资讯</b>
        <a class="fz12 c8c8 mzub-ac-aa"  href="#">更多</a>
    </div>
    <div class="plr30">
        <iframe id="iframe" src="http://rili-d.jin10.com/open.php" frameborder="0" height="300px" width="100%"></iframe>
    </div>
</div>
</body>
</html>

<script>
    $(function() {
        var mySwiper = new Swiper('.banner', {
            loop: true,
            autoplay: 500,
            speed: 3000,
            autoplayDisableOnInteraction: false,
            wrapperClass: 'banner-wrapper',
            slideClass: 'banner-slide',
            pagination: '.banner-pagination',
            paginationClickable: true,
        });
        var flage=true;
        $(".index-user-footer02 b:nth-child(1)").on("touchstart", function() {
            if(flage){
                $(this).addClass("active");
                flage=false;
            }else{
                $(this).removeClass("active");
                flage=true;
            }

        });
        $(".footer div").on("touchstart", function() {
            $(this).addClass("active").siblings().removeClass("active");
        });
        $("#caijin").on("click",function(){
            $("#iframe").attr("src","http://rili-d.jin10.com/open.php")
        })
    })
</script>