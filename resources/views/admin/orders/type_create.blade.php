@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.ordertypes.create') }}" >添加品种</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.ordertypes.index') }}" >品种列表</a></td>
        </tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="@if(empty($order_type)){{ route('admin.ordertypes.store') }} @else  {{ route('admin.ordertypes.update', ['ordertype'=>$order_type->id])}} @endif" id="dform" onsubmit="return check();">
        {{csrf_field()}}
        @isset($order_type) {{method_field('PUT')}} @endisset
        <table cellspacing="0" class="tb">

            <tr>
                <td class="tl"><span class="f_red">*</span> 品种名称</td>
                <td><input name="name" type="text" size="10" value="@isset($order_type){{$order_type->name}}@endisset" id="name"/><span id="dname" class="f_red"></span></td>
            </tr>

        </table>
        <div class="sbt"><input type="submit" name="submit" value="添 加" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取 消" class="btn" onclick="Go('?moduleid=17&file=index');"/></div>

    </form>

    <script>
        function check() {

            f = 'name';
            if(Dd(f).value == 0) {
                Dmsg('请填写品种名称', 'name', 1);
                return false;
            }
            return true;
        }
    </script>

    <script type="text/javascript">Menuon(0);</script>
@stop