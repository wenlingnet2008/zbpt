@section('header')
    @parent
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
@stop
@if(session('status'))
    <div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-success m-t-40">
        <span id="return-message">{{ session()->pull('status') }}</span>
        <a href="#" class="closed">×</a>
    </div>
@endif

@if(count($errors) > 0)
    <div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert-danger m-t-40">
            <span id="return-message">
                @foreach($errors->all() as $error)
                    {{ $error }} <br/>
                @endforeach
            </span>
        <a href="#" class="closed">×</a>
    </div>
@endif


@section('footer')
    @parent
    <script type="text/javascript">
        //Alerts
        $(".myadmin-alert .closed").click(function (event) {
            $(this).parents(".myadmin-alert").fadeToggle(350);
            return false;
        });
        /* Click to close */
        $(".myadmin-alert-click").click(function (event) {
            $(this).fadeToggle(350);
            return false;
        });
    </script>
@stop