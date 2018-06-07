@extends('layouts.admin.layout')

@section('menu')
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td id="Tab0" class="tab"><a href="{{ route('admin.categories.create') }}" >添加分类</a></td>
            <td id="Tab1" class="tab"><a href="{{ route('admin.categories.list') }}" >管理分类</a></td>
            <td id="Tab2" class="tab"><a href="{{ route('admin.categories.fixtree') }}" >修复分类</a></td></tr>
    </table>
@stop

@section('content')
    @include('admin.flash_error_or_success')
    <form method="post" action="{{ route('admin.categories.store') }}" onsubmit="return check();">
        {{ csrf_field() }}
        <input type="hidden" value="0" name="parent_id" id="parent_id">
        <table cellspacing="0" class="tb">
            <tr>

                <td class="tl"><span class="f_hid">*</span> 上级分类</td>
                <td><select name=""  id="parent_category">

                    </select> <img src="/admin/image/tips.png" width="16" height="16" title="如果不选择，则为顶级分类" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);" /></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 分类名称</td>
                <td><textarea name="name"  id="name" style="width:200px;height:100px;overflow:visible;"></textarea>
                    <img src="/admin/image/tips.png" width="16" height="16" title="允许批量添加，一行一个，点回车换行" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);" /><br/><span id="dname" class="f_red"></span></td>
            </tr>


        </table>
        <div class="sbt"><input type="submit" name="submit" value="确 定" class="btn-g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取 消" class="btn" onclick="Go('?');"/></div>
    </form>
    <script type="text/javascript">
        function check() {
            if(Dd('name').value == '') {
                Dmsg('请填写分类名称', 'name');
                return false;
            }
            return true;
        }
    </script>
    <script type="text/javascript">Menuon(0);</script>

@stop


@section('footer')
    @parent
    <!-- LinkageSel js-->
    <script src="{{ asset('admin/script/LinkageSel/comm.js') }}"></script>
    <script src="{{ asset('admin/script/LinkageSel/linkagesel-min.js') }}"></script>
    <script>
        var opts = {
            data: @json($top_categories),
            ajax: '{{ route('admin.categories.subcategory') }}',
            select: '#parent_category',
            fixWidth: 150,
            head: '请选择分类',
            loaderImg: '{{ asset('admin/script/LinkageSel/ui-anim_basic_16x16.gif') }}',
            autoLink: false,
            @isset($parent_ids)defVal: @json($parent_ids),@endisset
        };

        var linkageSel = new LinkageSel(opts);
        linkageSel.onChange(function() {
            var input = $('#parent_id');
            var v = linkageSel.getSelectedValue();
            input.val(v);
        });
    </script>
@endsection