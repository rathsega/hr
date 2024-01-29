<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Creativeitem Software Installation" />
	<meta name="author" content="Creativeitem" />
	<title>{{ __('Installation').' | '.__('Workplace') }}</title>
	
	<!-- CSRF Token for ajax for submission -->
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <!-- all the css files -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
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


    <!-- Datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" />
    <!-- Select2 css -->
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />

    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/toastr/toastr.min.css') }}">

    @stack('css')

    <!--Main Jquery-->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.7.1.min.js') }}"></script>


</head>
<body class="page-body">

<div class="page-container horizontal-menu">

	<header class="navbar navbar-fixed-top ins-one bg-dark">
		<div class="container">
			<div class="navbar-inner">
				<!-- logo -->
				<div class="navbar-brand">
					<a href="#">
						<img width="30px" src="{{ asset('assets/images/favicon.png') }}" alt="">
					</a>
					<span class="logo_name ms-4 text-white">{{ __('Installation') }}</span>
				</div>
			</div>
		</div>
	</header>
	<div class="main_content py-4">
		@yield('content')
	</div>

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


</body>
</html>