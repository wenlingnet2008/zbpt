
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8"/>
    <meta name="robots" content="noindex,nofollow"/>
    <title>管理员登录</title>
    <link rel="stylesheet" href="{{ asset('admin/image/login.css') }}" type="text/css" />
    <script type="text/javascript" src="{{ asset('admin/script/lang.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/script/config.js') }}"></script>
    <!--[if lte IE 9]><!-->
    <script type="text/javascript" src="{{ asset('admin/script/jquery-1.5.2.min.js') }}"></script>
    <!--<![endif]-->
    <!--[if (gte IE 10)|!(IE)]><!-->
    <script type="text/javascript" src="{{ asset('admin/script/jquery-2.1.1.min.js') }}"></script>
    <!--<![endif]-->
    <script type="text/javascript" src="{{ asset('admin/script/common.js') }}"></script>

</head>
<body>
<noscript><br/><br/><br/><center><h1>您的浏览器不支持JavaScript,请更换支持JavaScript的浏览器</h1></center></noscript>
<noframes><br/><br/><br/><center><h1>您的浏览器不支持框架,请更换支持框架的浏览器</h1></center></noframes>
<form method="post" action="{{ route('admin.checklogin') }}"  onsubmit="return Dcheck();">
    {{ csrf_field() }}
    <div class="login">
        <div id="msgs"></div>
        <div class="head">管理登录</div>
        <div class="main">
            <div><input name="email" type="text" id="username" placeholder="户名" value=""/></div>
            <div><input name="password" type="password" id="password" placeholder="密码" value=""/></div>
            <div><input type="submit" name="submit" value="登 录" tabindex="4" id="sbm"/><input type="button" id="btn" value="退 出" onclick="top.Go('/');">
            </div>

        </div>
    </div>
</form>
<div id="tips"></div>
<div id="kb" style="display:none;"></div>
<script type="text/javascript">
    @if(count($errors) > 0)
        Dmsgs('{{ $errors->all()[0] }}');
    @endif
    function Dmsgs(msg) {
        $('#tips').hide();
        $('#sbm').attr('disabled', true);
        $('#msgs').html(msg);
        $('#msgs').slideDown(100, function() {
            setTimeout(function() {$('#msgs').fadeOut(300);$('#sbm').attr('disabled', false);}, 3000);
        });
    }
    function Dcheck() {
        if(Dd('username').value.length < 2) {
            Dmsgs('请填写会员名');
            Dd('username').focus();
            return false;
        }
        if(Dd('password').value.length < 6) {
            Dmsgs('请填写密码');
            Dd('password').focus();
            return false;
        }
        return true;
    }
    $(function(){
        if(Dd('username').value == '') {
            Dd('username').focus();
        } else {
            Dd('password').focus();
        }

        if(window.screen.width < 1200) {
            setTimeout(function() {
                $('#tips').hide();
                $('#tips').html(window.screen.width+'px屏幕无法获得最佳体验，建议1200px以上');
                $('#tips').slideDown(600);
            }, 5000);
        }
        $('#tips').html('提示：为了系统安全');
        $('#tips').slideDown(600);
    });
</script>
</body>
</html>