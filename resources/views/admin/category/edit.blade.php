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
    <form method="post" action="{{ route('admin.categories.update', ['catid'=>$category['catid']]) }}" onsubmit="return check();">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" value="0" name="parent_id" id="parent_id">
        <table cellspacing="0" class="tb">
            <tr>

                <td class="tl"><span class="f_hid">*</span> 上级分类</td>
                <td><select name=""  id="parent_category">

                    </select> <img src="/admin/image/tips.png" width="16" height="16" title="如果不选择，则为顶级分类" alt="tips" class="c_p" onclick="Dconfirm(this.title, '', 450);" /></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 分类名称</td>
                <td>
                    <input name="name" type="text" id="name" size="20" value="{{ $category->name }}">
                    <span id="dname" class="f_red"></span></td>
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
    <script type="text/javascript">Menuon(1);</script>

@stop


@section('footer')
    @parent
    <!-- LinkageSel js-->
    <script src="{{ asset('admin/script/LinkageSel/comm.js') }}"></script>
    <script src="{{ asset('admin/script/LinkageSel/linkagesel-min.js') }}"></script>
    <script>
        var opts = {
            ajax: '{{ route('admin.categories.subcategory') }}',
            //selClass: 'form-control',
            select: '#parent_category',
            fixWidth: 150,
            head: '请选择分类',
            autoLink: false,
            loaderImg: '{{ asset('admin/script/LinkageSel/ui-anim_basic_16x16.gif') }}',
            defVal: @json($category['parent_ids']),
        };

        var linkageSel = new LinkageSel(opts);
        linkageSel.onChange(function() {
            var input = $('#parent_id');
            var v = linkageSel.getSelectedValue();
            if(v == null){
                input.val(0);
            }else {
                input.val(v);
            }

        });
    </script>
@endsection