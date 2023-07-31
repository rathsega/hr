<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Forgot Password | Creativeitem Workplace</title>
<!-- all the meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="HR manager" name="description" />
<meta content="Creativeitem" name="author" />
<!-- all the css files -->
<link rel="shortcut icon" href="{{asset('public/assets/images/logo.png')}}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/bootstrap-5.1.3/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/vendors/bootstrap-icons-1.9.1/bootstrap-icons.css')}}">

<!--Custom css-->
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/custom.css')}}">

</head>

<body>
<div class="container-fluid h-100">
<div class="row h-100">
  <div class="col-lg-6 d-none d-lg-block p-0 h-100">
    <div class="bg-image" style="width: inherit; height: 100%; position: fixed; background-image: url('{{asset('public/assets/images/login.png')}}'); background-size: cover; background-position: center;">
    </div>
  </div>
  <div class="col-lg-6 p-0 h-100 position-relative">
    <div class="parent-elem">
      <div class="middle-elem">
        <div class="primary-form">
          <img class="mb-5" width="230px" src="{{asset('public/assets/images/logo-login.png')}}">
          <div class="row">
            <div class="col-12">
              <div class="subtitle">
              </div>
            </div>
            <div class="col-md-12 mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
            <div class="col-12">
              <div class="login-form">
                <form action="{{ route('password.email') }}" method="post">
                  @Csrf

                  <div class="form-row">
                    <div class="form-group">
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" id="email"
                        placeholder="Your email address" required autofocus>
                      </div>
                      @if($errors->has('email'))
                      <small class="text-danger">
                        {{__($errors->first('email'))}}
                      </small>
                      @endif
                    </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('Email Password Reset Link') }}</button>
                        <a href="{{route('login')}}" class="btn mt-2 py-3 ms-0 ps-0"> <i class="bi bi-chevron-left"></i> {{ __('Back') }}</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Main Jquery-->
<script src="{{asset('public/assets/vendors/jquery/jquery-3.6.0.min.js')}}"></script>
<!--Bootstrap bundle with popper-->
<script src="{{asset('public/assets/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js')}}"></script>

<!--Custom Script-->
<script src="{{asset('public/assets/js/script.js')}}"></script>
<script src="{{asset('public/assets/js/custom.js')}}"></script>

</body>

</html>

