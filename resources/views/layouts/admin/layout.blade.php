<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8"/>
    <title>管理中心</title>
    <meta name="robots" content="noindex,nofollow"/>
    <meta http-equiv="x-ua-compatible" content="IE=8"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="bookmark" type="image/x-icon" href="/favicon.ico"/>
    <script type="text/javascript">window.onerror= function(){return true;}</script>
    <link rel="stylesheet" href="{{ asset('admin/image/style.css') }}" type="text/css" />
    <script type="text/javascript" src="{{ asset('admin/script/lang.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/script/config.js') }}"></script>
    <!--[if lte IE 9]><!-->
    <script type="text/javascript" src="{{ asset('admin/script/jquery-1.5.2.min.js') }}"></script>
    <!--<![endif]-->
    <!--[if (gte IE 10)|!(IE)]><!-->
    <script type="text/javascript" src="{{ asset('admin/script/jquery-2.1.1.min.js') }}"></script>
    <!--<![endif]-->
    <script type="text/javascript" src="{{ asset('admin/script/common.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/script/admin.js') }}"></script>
    @section('header')

    @show
</head>
<body>
<div id="msgbox" onmouseover="closemsg();" style="display:none;"></div>

<div class="menu" onselectstart="return false" id="destoon_menu">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td valign="bottom">
                @section('menu')

                @show
            </td>
            <td>
                <div>
                    <img src="/admin/image/tool-reload.png" width="16" height="16" title="刷新" onclick="window.location.reload();" alt=""/>
                    <img src="/admin/image/tool-search.png" width="16" height="16" title="搜索" onclick="Dwidget('?file=search', '后台搜索');" alt=""/>
                    <script type="text/javascript">
                        if(parent.location == window.location) {
                            document.write('<img src="/admin/image/tool-close.png" width="16" height="16" title="关闭" onclick="window.close();" alt=""/>');
                        } else {
                            document.write('<img src="/admin/image/tool-full.png" width="16" height="16" title="全屏" onclick="window.open(window.location.href);" alt=""/>');
                        }
                    </script>
                </div>
            </td>
        </tr>
    </table>
</div>

@section('content')

@show


@section('footer')

@show
<div class="back2top"><a href="javascript:void(0);" title="返回顶部">&nbsp;</a></div>
<script type="text/javascript">
</script>
</body>
</html>