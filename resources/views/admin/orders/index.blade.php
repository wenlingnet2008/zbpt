@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.orders.create') }}" >添加喊单</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.orders.index') }}" >喊单列表</a></td>
        </tr>
    </table>
@stop

@section('content')
    <div class="sbox">
        <form action="?">

            <input type="text" size="30" name="q" value="" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
            <input type="submit" name="submit" value="搜 索" class="btn"/>&nbsp;

        </form>
    </div>
    <form method="post">
        {{csrf_field()}}
        <table cellspacing="0" class="tb ls">
            <tr>

                <th>品种</th>
                <th>类型</th>
                <th>开仓价</th>
                <th>止损价</th>
                <th>止盈价</th>
                <th>仓位</th>
                <th>喊单人</th>
                <th width="100">操作</th>
            </tr>
                @foreach($orders as $order)
                <tr align="center">
                    <td>{{ $order->order_type->name }}</td>
                    <td>@if($order->doing) 做多 @else 做空 @endif</td>
                    <td>{{$order->open_price}}</td>
                    <td>{{$order->stop_price}}</td>
                    <td>{{$order->earn_price}}</td>
                    <td>{{$order->position}} %</td>
                    <td>{{$order->user->name}}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', ['order'=>$order->id]) }}">查看</a>&nbsp;
                        <a href="{{ route('admin.orders.edit', ['order'=>$order->id]) }}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
                        <a href="#" onclick="del({{$order->id}})"><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
                </tr>
                @endforeach
        </table>

    </form>
    <div class="btns">
        {{ $orders->links() }}
    </div>
    <script type="text/javascript">Menuon(1);</script>
    <script>
        function del(id) {
            var r=confirm("注意：确定要删除吗?");
            if (r==true)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/orders') }}/"+ id,
                    data: "_token={{ csrf_token() }}",
                    success: function(msg){
                        alert( msg.message );
                        location.reload();
                    }
                });
            }
        }
    </script>
@stop