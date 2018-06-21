
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $room->name }}</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/jquery-sinaEmotion-2.1.0.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <script type="text/javascript" src="/js/swfobject.js"></script>
    <script type="text/javascript" src="/js/web_socket.js"></script>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery-sinaEmotion-2.1.0.min.js"></script>

    <script type="text/javascript">
        if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
        // 如果浏览器不支持websocket，会使用这个flash自动模拟websocket协议，此过程对开发者透明
        WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
        // 开启flash的websocket debug
        WEB_SOCKET_DEBUG = true;
        var ws, name, client_list={};

        // 连接服务端
        function connect() {
            // 创建websocket
            ws = new WebSocket("ws://"+document.domain+":7272");

            // 当有消息时根据消息类型显示不同信息
            ws.onmessage = onmessage;
            ws.onclose = function(e) {
                console.log(e);
                console.log("连接关闭，定时重连");
                $.get('{{route('room.checkonline')}}', {}, function(data) {
                    //如果已经在线，则不重新连接，解决一个用户多个客户端同时连接问题
                    console.log(data.online);
                   if(data.online == 1){
                       location.href = '{{route('online.error')}}';
                       return;
                   }else if(data.online == 2){
                        location.href = '/firewall';
                        return;
                    }else{
                       connect();
                   }
                }, 'json');


            };
            ws.onerror = function() {
                console.log("出现错误");
            };
        }


        // 服务端发来消息时
        function onmessage(e)
        {
            var data = JSON.parse(e.data);
            switch(data['type']){
                // 服务端ping客户端
                case 'ping':
                    ws.send('{"type":"pong"}');
                    break;;
                case 'init':
                    $.post('{{route('room.login')}}', {
                        client_id: data.client_id,
                        room_id: '{{$room->id}}',
                        _token: '{{csrf_token()}}',
                    }, function(data) {
                        console.log(data);

                    }, 'json');
                    break;
                // 登录 更新用户列表
                case 'login':
                    say(data['user_id'], data['name'],  data['name']+' 加入了聊天室', data['time']);
                    if(data['client_list'])
                    {
                        client_list = data['client_list'];
                    }
                    else
                    {
                        if($.inArray(data['name'], client_list) == -1){
                            client_list[data['user_id']] = data['name'];
                        }

                    }
                    flush_client_list();
                    console.log(data['name']+"登录成功");
                    break;
                // 发言
                case 'say':
                    say(data['from_client_id'], data['from_client_name'], data['content'], data['time']);
                    break;
                // 用户退出 更新用户列表
                case 'logout':
                    say(data['user_id'], data['from_client_name'], data['from_client_name']+' 退出了', data['time']);
                    delete client_list[data['user_id']];
                    flush_client_list();
            }


        }


        // 提交对话
        function onSubmit() {
            var input = document.getElementById("textarea");
            var to_user_id = $("#client_list option:selected").attr("value");
            var to_client_name = $("#client_list option:selected").text();

            $.post('{{route('room.say')}}', {
                to_user_id: to_user_id,
                room_id: '{{$room->id}}',
                content: input.value,
                _token: '{{csrf_token()}}',
            }, function(data) {
                console.log(data);
                alert(data.message);
            }, 'json');

            input.value = "";
            input.focus();
        }

        // 刷新用户列表框
        function flush_client_list(){
            var userlist_window = $("#userlist");
            var client_list_slelect = $("#client_list");
            userlist_window.empty();
            client_list_slelect.empty();
            userlist_window.append('<h4>在线用户</h4><ul>');
            client_list_slelect.append('<option value="all" id="cli_all">所有人</option>');
            for(var p in client_list){
                userlist_window.append('<li id="'+p+'">'+client_list[p]+'</li>');
                client_list_slelect.append('<option value="'+p+'">'+client_list[p]+'</option>');
            }
            $("#client_list").val(select_client_id);
            userlist_window.append('</ul>');
        }

        // 发言
        function say(from_client_id, from_client_name, content, time){
            //解析新浪微博图片
            content = content.replace(/(http|https):\/\/[\w]+.sinaimg.cn[\S]+(jpg|png|gif)/gi, function(img){
                return "<a target='_blank' href='"+img+"'>"+"<img src='"+img+"'>"+"</a>";}
            );

            //解析url
            content = content.replace(/(http|https):\/\/[\S]+/gi, function(url){
                    if(url.indexOf(".sinaimg.cn/") < 0)
                        return "<a target='_blank' href='"+url+"'>"+url+"</a>";
                    else
                        return url;
                }
            );

            $("#dialog").append('<div class="speech_item"> '+from_client_name+' <br> '+time+'<div style="clear:both;"></div><p class="triangle-isosceles top">'+content+'</p> </div>').parseEmotion();
        }

        $(function(){
            select_client_id = 'all';
            $("#client_list").change(function(){
                select_client_id = $("#client_list option:selected").attr("value");
            });
            $('.face').click(function(event){
                $(this).sinaEmotion();
                event.stopPropagation();
            });

            $('#kick').click(function (event) {
                var user_id = $("#client_list option:selected").attr("value");
                $.post('{{route('room.kick')}}',{
                    room_id: '{{$room->id}}',
                    user_id: user_id,
                    _token: '{{csrf_token()}}',
                },function(data) {
                    console.log(data);
                    alert(data.message);
                }, 'json');
            });

            $('#mute').click(function (event) {
                var user_id = $("#client_list option:selected").attr("value");
                $.post('{{route('room.mute')}}',{
                    user_id: user_id,
                    _token: '{{csrf_token()}}',
                },function(data) {
                    console.log(data);
                    alert(data.message);
                }, 'json');
            });

            $('#unmute').click(function (event) {
                var user_id = $("#client_list option:selected").attr("value");
                $.post('{{route('room.unmute')}}',{
                    user_id: user_id,
                    _token: '{{csrf_token()}}',
                },function(data) {
                    console.log(data);
                    alert(data.message);
                }, 'json');
            });
        });


    </script>
</head>
<body onload="connect();">
<div class="container">
    <div class="row clearfix">
        <div class="col-md-1 column">
        </div>
        <div class="col-md-6 column">
            <div class="thumbnail">
                <div class="caption" id="dialog">
                    @foreach($messages as $message)
                        <div class="speech_item">{{ $message->user_name }} <br> {{$message->created_at}}<div style="clear:both;"></div><p class="triangle-isosceles top">{{$message->content}}</p> </div>

                    @endforeach
                </div>
            </div>
            <form onsubmit="onSubmit(); return false;">
                <select style="margin-bottom:8px" id="client_list">
                    <option value="all">所有人</option>
                </select>
                <textarea class="textarea thumbnail" id="textarea"></textarea>
                <div class="say-btn">
                    <!--<input type="button" class="btn btn-default face pull-left" value="表情" />-->
                    <!--<input type="button" id="flush" value="刷新用户列表" />-->
                    <input type="submit" class="btn btn-default" value="发表" />
                </div>
            </form>

        </div>
        <div class="col-md-3 column">
            <div class="thumbnail">
                <div class="caption" id="userlist"></div>
            </div>
            <input type="button" class="btn btn-default" value="踢出房间,限制ip" id="kick"/>
            <input type="button" class="btn btn-default" value="禁止发言" id="mute"/>
            <input type="button" class="btn btn-default" value="解除禁言" id="unmute"/>
        </div>
    </div>
</div>
</body>
</html>
