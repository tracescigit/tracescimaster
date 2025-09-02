@extends('../layout/base')

@section('body')
<body class="main">
    @yield('content')
    <x-progress></x-progress>
    @include('../layout/components/dark-mode-switcher')

    <!-- BEGIN: JS Assets-->
    @yield('global_script')
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkYcFk5rZMvW2Sf0JnCZm9YGvG-Zwgb2U&libraries=places"></script>
    <script src="{{ mix('dist/js/app.js') }}"></script>
    <script src="{{ asset('dist/js/tinymce/tinymce.min.js')}}"></script>
    <script src="{{ asset('dist/js/actions.js') }}"></script>
    <!-- END: JS Assets-->
    @yield('script')

    <script>

        function openFullscreen(param) {
            var open = cash('.full-screen').data('open');

            if(open=='0'){
                cash('.side-nav').addClass('w-0');
                cash('.side-menu').hide();
                cash('.full-screen').data('open',1);
                cash('.maximize').hide();
                cash('.minimize').show();
                
            }else{
                cash('.side-nav').removeClass('w-0');
                cash('.side-menu').show();
                cash('.full-screen').data('open',0);
                cash('.minimize').hide();
                cash('.maximize').show();
                
            }
        }

        @if(request()->is('vendor*') && env('APP_ENV')!='local')
        setInterval(function() {
            axios.get('{{ url('vendor/getrecords/credits') }}').then(res => {
                if(res.data.credit){
                    cash('.credit-notification').html(res.data.credit);
                }

                if (res.data.inprogress && res.data.inprogress!='') {
                    cash('.progress-notification').show()
                    cash('.progress-notification').html(res.data.inprogress)
                    cash('#upload-codes-btn').hide()
                }else{
                    cash('.progress-notification').hide()
                    cash('#upload-codes-btn').show()
                }

                if(res.data.notify && res.data.notify!=''){
                    cash('#progress-btn').trigger('click')
                    cash('.progress-details-div').html(res.data.notify)
                }

            }).catch(e=>{
                cash('.credit-notification').html('');
            });
        },3000)
        @endif

    </script>
</body>
@endsection