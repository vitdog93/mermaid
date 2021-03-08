@if ($message = Session::get('success'))
    {{session()->put('success', '')}}
    <script>
        notify('zmdi zmdi-check zmdi-hc-fw', 'success', '{{ __('Thông báo') }}', '{{ $message }}');
    </script>
@endif

@if ($message = Session::get('error'))
    {{session()->put('error', '')}}
    <script>
        notify('zmdi zmdi-alert-polygon zmdi-hc-fw', 'danger', '{{ __('Xảy ra lỗi') }}', '{{ $message }}');
    </script>
@endif

@if ($message = Session::get('warning'))
    {{session()->put('warning', '')}}
    <script>
        notify('zmdi zmdi-alert-triangle zmdi-hc-fw', 'warning', '{{ __('Cảnh báo') }}', '{{ $message }}');
    </script>
@endif

@if ($message = Session::get('info'))
    {{session()->put('info', '')}}
    <script>
        notify('zmdi zmdi-info zmdi-hc-fw', 'info', '{{ __('Thông báo') }}', '{{ $message }}');
    </script>
@endif
