@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{route('admin.paras.create')}}?catid={{$category->catid}}">添加属性</a></td>
            <td id="Tab1" class="tab"><a href="{{route('admin.paras.index')}}?catid={{$category->catid}}">属性参数</a></td>
            <td id="Tab2" class="tab"><a href="{{route('admin.paras.copy')}}?catid={{$category->catid}}">复制属性</a></td>
        </tr>

    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.paras.update', ['dpid'=>$para['dpid']]) }}" id="dform" onsubmit="return check();">

        <input type="hidden" name="catid" value="{{ $para->catid }}"/>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 属性名称</td>
                <td><input name="name" type="text"  size="30" id="name" value="{{ $para->name }}"/> <span id="dname" class="f_red"></span></td>
            </tr>

            <tr>
                <td class="tl" id="v_l"><span class="f_red">*</span> 修改默认值</td>
                <td>

                    @foreach($values as $dvid => $value)
                    <input name="oldvalue[{{$dvid}}]" type="text"  size="30"  value="@if(old('oldvalue')){{old('oldvalue.'.$dvid)}}@else{{ $value }}@endif"/><br/><br/>
                    @endforeach

                    <span id="dname" class="f_red">为空 表示删除该值</span>
                </td>
            </tr>

            <tr>
                <td class="tl" id="v_l"><span class="f_red">*</span> 添加默认值</td>
                <td><textarea name="value" style="width:50%;height:150px;overflow:visible;" id="value">@if(old('value')){{ old('value') }}@endif</textarea><br/>
                    <img src="/admin/image/tips.png" width="16" height="16" title="允许批量添加，一行一个，点回车换行" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);" /></td>
            </tr>

        </table>
        <div class="sbt"><input type="submit" name="submit" value="更新" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取 消" class="btn" onclick="Go('');"/></div>
    </form>
    <script type="text/javascript">

        function check() {
            var l;
            var f;
            f = 'name';
            l = Dd(f).value.length;
            if(l < 1) {
                Dmsg('请填写属性名称', f);
                return false;
            }
            return true;
        }
    </script>
    <script type="text/javascript">Menuon(0);</script>

@stop
