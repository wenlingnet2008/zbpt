@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.firewall.index') }}" >IP屏蔽</a></td>
        </tr>
    </table>
@stop


@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{route('admin.firewall.delete')}}">
        {{csrf_field()}}
        {{method_field('DELETE')}}
        <table cellspacing="0" class="tb ls">
            <tr>
                <th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
                <th>IP地址/段</th>
                <th>类型</th>
                <th>禁止时间</th>
            </tr>
            @foreach($firewalls as $firewall)
            <tr align="center">
                <td><input type="checkbox" name="ips[]" value="{{$firewall->ip_address}}"/></td>
                <td>{{$firewall->ip_address}}</td>
                <td><span style="color:blue;">@if($firewall->whitelisted)白名单@else黑名单@endif</span></td>
                <td>{{$firewall->created_at}}</td>
            </tr>
            @endforeach
        </table>
        <div class="btns">
            <input type="submit" value=" 批量删除 " class="btn-r" onclick="if(confirm('确定要删除选中记录吗？此操作将不可撤销')){this.form.action='?file=banip&action=delete'}else{return false;}"/>&nbsp;&nbsp;
        </div>
    </form>
    <div class="tt">IP禁止</div>
    <form action="{{route('admin.firewall.store')}}" method="post">
        {{csrf_field()}}
        <table cellspacing="0" class="tb">
            <tr>
                <td>&nbsp;
                    IP地址/段 <input type="text" size="30" name="ip_address"/>&nbsp;
                    <input type="submit" value="添 加" class="btn-g"/>&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;支持格式 : 192.168.0.1  ,  192.168.0.1-192.168.0.10  , 192.168.*.* , 192.168.0.0/16<br/>

                </td>
            </tr>
        </table>
    </form>
    <script type="text/javascript">Menuon(0);</script>

@stop