<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ DB::table('routes')->where('route_name', Route::currentRouteName())->value('title'); }} | Creativeitem Workplace</title>

  <!-- all the meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="Creativeitem Workplace" name="description" />
  <meta content="Creativeitem" name="author" />


  <!-- all the css files -->
  <link rel="shortcut icon" href="{{asset('public/assets/images/logo.png')}}">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/bootstrap-5.1.3/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/swiper-bundle.min.css')}}"/>
  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/bootstrap-icons-1.9.1/bootstrap-icons.css')}}">

  <!--Custom css-->
  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/style.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/custom.css')}}">

  <!-- Datepicker css -->
  <link rel="stylesheet" href="{{asset('public/assets/css/daterangepicker.css')}}" />
  <!-- Select2 css -->
  <link rel="stylesheet" href="{{asset('public/assets/css/select2.min.css')}}" />
  
  <!-- Toastr -->
  <link rel="stylesheet" type="text/css" href="{{asset('public/assets/toastr/toastr.min.css')}}">

  <!--Main Jquery-->
  <script src="{{asset('public/assets/vendors/jquery/jquery-3.6.0.min.js')}}"></script>
</head>
<body>
  @include(auth()->user()->role.'.navigation')
  <section class="home-section">
    <div class="home-content">
      @include('header')

      <div class="main_content">
        
        <div class="mainSection-title">
          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <h4>{{ DB::table('routes')->where('route_name', Route::currentRouteName())->value('page_title'); }}</h4>
              </div>
            </div>
          </div>
        </div>

        @yield('content')
        
      </div>
    </div>
  </section>

  
  <!--Bootstrap bundle with popper-->
  <script src="{{asset('public/assets/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/assets/js/swiper-bundle.min.js')}}"></script>
  <!-- Datepicker js -->
  <script src="{{asset('public/assets/js/moment.min.js')}}"></script>
  <script src="{{asset('public/assets/js/daterangepicker.min.js')}}"></script>
  <!-- Select2 js -->
  <script src="{{asset('public/assets/js/select2.min.js')}}"></script>

  <script src="{{asset('public/assets/js/jquery-ui.js')}}"></script>
  <script src="{{asset('public/assets/global/jquery-form/jquery.form.min.js')}}"></script>

  <!-- Toastr -->
  <script src="{{asset('public/assets/toastr/toastr.min.js')}}"></script>

  <!--Custom Script-->
  <script src="{{asset('public/assets/js/script.js')}}"></script>
  <script src="{{asset('public/assets/js/custom.js')}}"></script>

  @include('modal')
  @include('common_scripts')
  @include('init')
  @stack('js')
</body>
</html>