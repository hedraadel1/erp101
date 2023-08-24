<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- custom metas -->
    @if (!empty($__site_details['meta_tags']))
        {!! $__site_details['meta_tags'] !!}
    @endif

    @yield('meta')

    <!-- font awesome 5 free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <!-- Bootstrap 5 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('Modules/cms/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"
        integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="stylesheet" href="{{ Module::asset('cms:css/bootstrap.min.css') }}"> --}}

    <!-- Your Custom CSS file that will include your blocks CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('modules/cms/css/cms.css?v=' . $asset_v) }}">
    <script src="https://unpkg.com/tua-body-scroll-lock"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name', 'ultimatePOS') }}</title>
    <!-- custom css code -->
    @if (!empty($__site_details['custom_css']))
        {!! $__site_details['custom_css'] !!}
    @endif
    @yield('css')
</head>

<body style="direction: rtl">
    @yield('content')
    @includeIf('cms::frontend.layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"
        integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
        integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/tua-body-scroll-lock"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sticky-js/1.3.0/sticky.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script> --}}
    {{-- <script src="{{ asset('modules/cms/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('modules/cms/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('Modules/cms/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('modules/cms/assets/js/splide.min.js') }}"></script> --}}

    <!-- Google analytics code -->
    @if (!empty($__site_details['google_analytics']))
        {!! $__site_details['google_analytics'] !!}
    @endif

    <!-- facebook pixel code -->
    @if (!empty($__site_details['fb_pixel']))
        {!! $__site_details['fb_pixel'] !!}
    @endif

    <!-- custom js -->
    @if (!empty($__site_details['custom_js']))
        {!! $__site_details['custom_js'] !!}
    @endif

    <!-- chat_widget -->
    @if (!empty($__site_details['chat_widget']))
        {!! $__site_details['chat_widget'] !!}
    @endif

    @yield('javascript')
</body>

</html>
