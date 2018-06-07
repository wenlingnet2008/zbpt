@extends('layouts.admin.layout')
@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.categories.create') }}">添加分类</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.categories.list') }}">管理分类</a></td>
            <td id="Tab2" class="tab"><a href="{{ route('admin.categories.fixtree') }}">修复分类</a></td>
        </tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
<div class="sbox">
    <form action="{{ route('admin.categories.search') }}">

        <input type="text" size="30" name="q" value="@isset($q){{ $q }}@endisset" placeholder="请输入关键词" title="请输入关键词"/>&nbsp;
        <input type="submit" name="submit" value="搜 索" class="btn"/>&nbsp;

    </form>
</div>
<form method="post">
    {{csrf_field()}}
    @if(request()->route('catid'))
    <div class="tt">
        <a href="{{ route('admin.categories.list') }}">分类</a> -
        @foreach($bread_nav as $category)
            <a href="{{ route('admin.categories.list', ['catid'=>$category['catid']]) }}" @if ($loop->last)class="t" @endif >{{ $category['name'] }}</a> @if ($loop->last) @else - @endif
        @endforeach


    </div>
    @endif
    <table cellspacing="0" class="tb ls">
        <tr>
            <th width="20"><input type="checkbox" onclick="checkall(this.form);"/></th>
            <th>排序</th>
            <th>分类名</th>
            <th>信息量</th>
            <th>子类</th>
            <th>属性</th>
            <th width="100">操作</th>
        </tr>
        @foreach($categories as $k => $category)
        <tr align="center">
            <td><input type="checkbox" name="catids[]" value="{{$category->catid}}"/></td>
            <td><input name="category[{{ $category->catid }}][list_order]" type="text" size="3" value="{{$category->list_order}}"/></td>
            <td>
                <input name="category[{{ $category->catid }}][name]" type="text" value="{{ $category->name }}" style="width:200px;color:"/>
            </td>
            <td>0</td>
            <td title="管理子分类"><a href="{{ route('admin.categories.list', ['catid'=>$category['catid']]) }}">{{ $category->descendants_count }}</a></td>
            <td title="管理属性"><a href="javascript:Dwidget('{{ route('admin.paras.index') }}?catid={{$category->catid}}', '[{{ $category->name }}]扩展属性');">{{ $category->paras_count }}</a></td>
            <td>
                <a href="{{ route('admin.categories.create') }}?catid={{$category->catid}}"><img src="/admin/image/add.png" width="16" height="16" title="添加子分类" alt=""/></a>&nbsp;
                <a href="{{ route('admin.categories.edit', ['catid'=>$category->catid]) }}"><img src="/admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
                <a href="#" onclick="return delete_category({{$category->catid}});"><img src="/admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
        </tr>
        @endforeach
    </table>
    <div class="btns">
<span class="f_r">
分类总数:<strong class="f_red">{{ $total }}</strong>&nbsp;&nbsp;
当前目录:<strong class="f_blue">{{ $categories->count() }}</strong>&nbsp;&nbsp;
</span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="submit" value="更新分类" class="btn-g" onclick="this.form.action='{{ route('admin.categories.list') }}'"/>&nbsp;&nbsp;

    </div>
</form>

<div class="tt">注意事项</div>
<table cellspacing="0" class="tb">
    <tr>
        <td class="lh20">&nbsp;&nbsp;
            &nbsp;&nbsp;<span class="f_red">删除分类</span>会将该分类下的所有分类删除，没有特殊情况不建议直接删除分类<br/>

        </td>
    </tr>
</table>
<script type="text/javascript">
    function Prop(t, n) {
        mkDialog('', '<iframe src="?file=property&catid='+n+'" width="700" height=300" border="0" vspace="0" hspace="0" marginwidth="0" marginheight="0" framespacing="0" frameborder="0" scrolling="yes"></iframe>', '['+t+']扩展属性', 720, 0, 0);
    }
</script>
<script type="text/javascript">Menuon(1);</script>
@stop

<script>
    function delete_category(catid) {
        var r=confirm("注意：删除此分类将会连它的子类也删除,确定要删除吗?");
        if (r==true)
        {
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/categories') }}/"+ catid,
                data: "_token={{ csrf_token() }}",
                success: function(msg){
                    alert( msg.message );
                    location.reload();
                }
            });
        }
    }
</script>