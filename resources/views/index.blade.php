<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>@stack('title') | {{ get_settings('website_title') }}</title>

    <!-- all the meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta content="Creativeitem Workplace" name="description" />
    <meta content="Creativeitem" name="author" />
    <link rel="shortcut icon" href="{{get_image(get_settings('favicon'))}}" />
    <meta content="{{csrf_token()}}" name="csrf_token" />
    @stack('meta')
    <!-- End meta -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-5.1.3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-icons-1.9.1/bootstrap-icons.css') }}">

    {{-- FlatIcons --}}
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/icons/uicons-thin-rounded/css/uicons-thin-rounded.css') }}" />

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">

    <!-- Datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" />
    <!-- Select2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />

    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/toastr/toastr.min.css') }}">

    <!-- Org chart -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.orgchart.css') }}">

    @stack('css')

    <!--Main Jquery-->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.7.1.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/apextree"></script>

</head>

<body>
    @include(auth()->user()->role . '.navigation')
    <section class="home-section">
        <div class="home-content">
            @include('header')

            <div class="main_content">
                
                @yield('content')

            </div>
        </div>
    </section>


    <!--Bootstrap bundle with popper-->
    <script src="{{ asset('assets/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <!-- Datepicker js -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
    <!-- Select2 js -->
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/global/jquery-form/jquery.form.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>

    <!--Custom Script-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Org Chart -->
    <script src="{{ asset('assets/js/jquery.orgchart.js') }}"></script>

    @include('modal')
    @include('common_scripts')
    @include('init')
    @stack('js')
</body>

</html>
