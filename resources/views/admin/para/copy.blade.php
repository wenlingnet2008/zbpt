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


    <form method="post" action="{{ route('admin.paras.copy') }}" onsubmit="return check();">
        <input type="hidden" name="catid" value="{{ $category->catid }}"/>
        {{csrf_field()}}
        <table cellspacing="0" class="tb">
            <tr>
                <td class="tl"><span class="f_red">*</span> 复制方式</td>
                <td>
                    <input type="radio" name="type" value="1" id="t1" onclick="Ds('f1');Dh('f2');" checked/> <label for="t1">批量</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="type" value="0" id="t2" onclick="Ds('f2');Dh('f1');"/> <label for="t2">单项</label>
                </td>
            </tr>
            <tbody id="f1" style="display:;">

            <tr>
                <td class="tl"><span class="f_red">*</span> 来源分类</td>
                <td>
                    <select name="fromid"  id="catid_1">

                    </select><span id="dfromid" class="f_red"></span>
                </td>
            </tr>
            </tbody>
            <tr id="f2" style="display:none;">
                <td class="tl"><span class="f_red">*</span> 属性ID</td>
                <td><input type="text" size="10" name="dpid" id="pid"/><span id="dpid" class="f_red"></span></td>
            </tr>
            <tr>
                <td class="tl"><span class="f_red">*</span> 同名过滤</td>
                <td>
                    <input type="radio" name="name" value="1" id="n1" checked/> <label for="n1">是</label>&nbsp;&nbsp;&nbsp;&nbsp;

                </td>
            </tr>
        </table>
        <div class="sbt"><input type="submit" name="submit" value="复 制" class="btn-g"/></div>
    </form>
    <script type="text/javascript">
        function check() {
            if(Dd('t1').checked) {
                if(Dd('catid_1').value==0) {
                    Dmsg('请选择来源分类', 'fromid');
                    return false;
                }
                if(Dd('catid_1').value=={{$category->catid}}) {
                    Dmsg('来源分类不能与当前分类相同', 'fromid');
                    return false;
                }
            } else {
                if(Dd('pid').value=='') {
                    Dmsg('请填写属性ID', 'pid');
                    return false;
                }
            }
            return true;
        }
    </script>
    <script type="text/javascript">Menuon(2);</script>

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
            select: '#catid_1',
            fixWidth: 150,
            head: '请选择分类',
            loaderImg: '{{ asset('admin/script/LinkageSel/ui-anim_basic_16x16.gif') }}',
            autoLink: false,
        };

        var linkageSel = new LinkageSel(opts);
        linkageSel.onChange(function() {
            var input = $('#parent_id');
            var v = linkageSel.getSelectedValue();
            input.val(v);
        });
    </script>
@endsection