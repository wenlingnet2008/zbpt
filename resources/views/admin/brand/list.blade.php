@extends('layouts.admin.layout')
@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.brands.create') }}" >添加品牌</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.brands.index') }}" >管理品牌</a></td>
        </tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <div class="sbox">
        <form action="{{ route('admin.brands.search') }}">

            <input type="text" size="30" name="q" value="@isset($q){{ $q }}@endisset" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
            <input type="submit" name="submit" value="搜 索" class="btn"/>&nbsp;

        </form>
    </div>
    <form method="post">
        {{csrf_field()}}

        <table cellspacing="0" class="tb ls">
            <tr>
                <th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>

                <th>品牌名称</th>
                <th>Logo</th>
                <th>系列</th>
                <th>数量</th>
                <th width="100">操作</th>
            </tr>
            @foreach($brands as $k => $brand)
                <tr align="center">
                    <td><input type="checkbox" name="brandids[]" value="{{$brand->brandid}}"/></td>
                    <td>
                        {{ $brand->name }}
                    </td>
                    <td><a href="javascript:_preview('{{ json_decode($brand->thumb, true)['thumb1'] }}');"><img src="{{ json_decode($brand->thumb, true)['thumb1'] }}" width="60" style="padding:5px;"/></a></td>
                    <td title="管理系列"><a href="javascript:Dwidget('?file=property&catid=1', '[品牌名称]系列');">0</a></td>
                    <td title="型号数量">0</td>
                    <td>

                        <a href="{{ route('admin.brands.edit', ['brandid'=>$brand['brandid']]) }}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
                        <a href="#" onclick="return delete_brand({{ $brand->brandid }});"><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
                </tr>
            @endforeach
        </table>
        <div class="btns">
            {{ $brands->links() }}
        </div>
    </form>

    <script type="text/javascript">Menuon(1);</script>
@stop


<script>
    function delete_brand(brandid) {
        var r=confirm("确定要删除吗?");
        if (r==true) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/brands') }}/" + brandid,
                data: "_token={{ csrf_token() }}",
                success: function (msg) {
                    alert(msg.message);
                    location.reload();
                }
            });
        }
    }
</script>
