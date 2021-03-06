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
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.orders.update', ['order'=>$order->id]) }}" id="dform" onsubmit="return check();">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 喊单品种</td>
                <td><select name="order[type_id]"  id="catid_1">
                        <option value="0">选择品种</option>
                        @foreach($order_types as $order_type)
                            <option value="{{$order_type->id}}" @if($order_type->id == $order->type_id) selected @endif>{{$order_type->name}}</option>
                        @endforeach
                    </select><span id="dcatid" class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 喊单类型</td>
                <td> <select name="order[doing]" >
                        <option value="0" @if($order->doing == 0) selected @endif>做空</option>
                        <option value="1" @if($order->doing == 1) selected @endif>做多</option>
                    </select>
                    <br/><span id="ddoing" class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 开仓价</td>
                <td><input name="order[open_price]" id="open_price" type="text" size="10" value="{{$order->open_price}}"/>&nbsp;&nbsp;
                    <span id="dopen_price" class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 止损价</td>
                <td><input name="order[stop_price]" type="text" size="10" value="{{$order->stop_price}}" id="stop_price"/><span id="dstop_price" class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 止盈价</td>
                <td><input name="order[earn_price]" type="text" size="10" value="{{$order->earn_price}}" id="earn_price"/><span id="dearn_price" class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 仓位</td>
                <td><input name="order[position]" type="text" size="10" value="{{$order->position}}" id="position"/> % <span id="dposition" class="f_red"></span></td>
            </tr>

            <tr>
                <td class="tl"><span class="f_red">*</span> 盈亏</td>
                <td><input name="order[profit_loss]" type="text" size="10" value="{{$order->profit_loss}}" id="profit_loss"/> <span id="dprofit_loss" class="f_red"></span></td>
            </tr>

            <tr>
                <td class="tl"> 可查看的用户组</td>
                <td>
                    <span id="roles_list">
                    @foreach($roles as $k => $role)
                            <input type="checkbox" name="roles[]" value="{{$role->name}}" @if(in_array($role->name, $order_roles)) checked @endif id="menu_c_{{$k}}"><label for="menu_c_{{$k}}"> {{ $role->name }}</label>
                        @endforeach
                    </span>
                    <a href="javascript:check_box('roles_list', true);" class="t">全选</a> / <a href="javascript:check_box('roles_list', false);" class="t">全不选</a>
                </td>
            </tr>

        </table>
        <div class="sbt"><input type="submit" name="submit" value="更新" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取 消" class="btn" onclick="Go('?moduleid=17&file=index');"/></div>

    </form>

    <script>
        function check() {
            var l;
            var f;
            f = 'catid_1';
            if(Dd(f).value == 0) {
                Dmsg('请选择所属品种', 'catid', 1);
                return false;
            }
            return true;
        }
    </script>

    <script type="text/javascript">Menuon(1);</script>
@stop