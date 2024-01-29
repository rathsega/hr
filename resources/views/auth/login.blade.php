<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{get_phrase('Login')}} | {{get_settings('website_title')}}</title>
    <!-- all the meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Creativeitem workplace" name="description" />
    <meta content="Creativeitem" name="author" />
    <!-- all the css files -->
    <link rel="shortcut icon" href="{{get_image(get_settings('favicon'))}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-5.1.3/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-icons-1.9.1/bootstrap-icons.css') }}">

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">

</head>

<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                <div class="bg-image w-inherit h-100 position-fixed"
                    style="background-image: url('{{ asset('assets/images/login.jpeg') }}'); background-size: cover; background-position: center; filter: grayscale(1);">
                </div>
            </div>
            <div class="col-lg-6 p-0 h-100 position-relative">
                <div class="parent-elem">
                    <div class="middle-elem">
                        <div class="primary-form">
                            <img class="mb-4" width="230px" src="{{ get_image(get_settings('dark_logo')) }}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="subtitle">
                                        <p>{{get_phrase('See your growth and get consulting support!')}}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="login-form">
                                        <form action="{{ route('login') }}" method="post">
                                            @Csrf

                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">{{get_phrase('Email')}}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                        <input type="email" name="email" class="form-control mb-0" id="email" placeholder="Your email address"
                                                            value="{{ old('email') }}">
                                                    </div>
                                                    @if ($errors->has('email'))
                                                        <small class="text-danger">
                                                            {{ get_phrase($errors->first('email')) }}
                                                        </small>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="form-label">{{get_phrase('Password')}}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                        <input type="password" name="password" class="form-control" id="password" placeholder="8+ Strong character">
                                                        <span class="input-group-text pe-18px ps-8px cursor-pointer show-password"><i class="bi bi-eye-slash"></i></span>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <small class="text-danger">
                                                            {{ get_phrase($errors->first('password')) }}
                                                        </small>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <div class="w-100">
                                                        <input type="checkbox" name="remember" id="remember_me">
                                                        <label class="cursor-pointer" for="remember_me">{{get_phrase('Remember me')}}</label>

                                                        @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}" class="float-end">{{ get_phrase('Forgot your password?') }}</a>
                                                        @endif

                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">{{get_phrase('Login')}}</button>
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
    <script src="{{ asset('assets/vendors/jquery/jquery-3.7.1.min.js') }}"></script>
    <!--Bootstrap bundle with popper-->
    <script src="{{ asset('assets/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}"></script>

    <!--Custom Script-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

</body>

</html>
