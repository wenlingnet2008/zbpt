@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.paras.create') }}?catid={{ $category->catid }}">添加属性</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.paras.index') }}?catid={{ $category->catid }}">属性参数</a></td>
            <td id="Tab2" class="tab"><a href="{{route('admin.paras.copy')}}?catid={{$category->catid}}">复制属性</a></td>
        </tr>

    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')

    <form method="post" action="{{route('admin.paras.batchupdate')}}">
        {{ csrf_field() }}
        <input type="hidden" name="catid" value="{{$category->catid}}"/>
        <table cellspacing="0" class="tb ls">
            <tr>
                <th width="40">更新</th>
                <th width="40">排序</th>
                <th>名称</th>
                <th>默认值</th>
                <th width="100">操作</th>
            </tr>
            @foreach($paras as $para)
            <tr align="center">
                <td><input name="dpid[]" type="checkbox" value="{{$para->dpid}}"/></td>
                <td><input type="text" size="2" name="list_order[{{$para->dpid}}]" value="{{$para->list_order}}"/></td>
                <td>{{ $para->name }}</td>
                <td>{{ implode('|', $para->values->pluck('value')->toArray()) }}</td>
                <td>
                    <a href="{{route('admin.paras.edit', ['dpid'=>$para->dpid])}}?catid={{$category->catid}}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>
                    <a href="#" onclick="return delete_para({{ $para->dpid }});"><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""></a>
                </td>
            </tr>
            @endforeach
            <tr>
                <td align="center"><input type="checkbox" onclick="checkall(this.form);" title="全选/反选"/></td>
                <td colspan="8"><input type="submit" name="submit" value="更 新"  class="btn-g"/>
                </td>
            </tr>
        </table>
    </form>
    <script type="text/javascript">Menuon(1);</script>


    <script>
        function delete_para(dpid) {
            var r=confirm("注意：确定要删除吗?");
            if (r==true)
            {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/paras') }}/"+ dpid,
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
