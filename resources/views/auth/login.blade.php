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
    <!-- --------font----------------- -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=Nanum+Gothic+Coding&family=Ojuju:wght@200..800&family=Satisfy&family=Teko:wght@300..700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div id="carouselExampleAutoplaying" class="carousel slide col-lg-6" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if($slides)
                    @foreach($slides as $key => $slide)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        @if($slide['type'] == 'quote')
                        <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                            <div class="bg-image w-inherit h-100 position-fixed" style="background-image: url('{{ asset('assets/images/quote_bg.png') }}'); background-size: cover; background-position: center;">
                                <div class="text-center">
                                    <img class="mb-2 mt-4" width="230px" src="{{ asset('assets/images/zettamine-transparent.png') }}" alt="">
                                    <div>
                                        <h5 class="quotes-heading text-center pt-3">Quotation of the day </h5>
                                        <img class="" width="260px" src="{{ asset('assets/images/under_line.png') }}" alt="">
                                    </div>
                                    <div class="container mt-4 quote-image-bg">
                                        <div class="d-flex">
                                            <!-- Quote Image Section -->
                                            <div class="col-md-8">
                                                <div>
                                                    <p class="pt-5 quote-para">{{$slide['quote']}}</p>
                                                    <div class="mt-3 details-sec">
                                                        <h6 class="quote-name"> - {{$slide['name']}}</h6>
                                                        <p class="quote-role">{{$slide['designation']}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Emblem Image Section -->
                                            <div class="col-md-4">
                                                <div>
                                                    <img class="quote-employe-pic pt-2" src="{{ $slide['photo'] ? get_image('uploads/user-image/' . $slide['photo']) : asset('assets/images/employe-quote.png') }}" alt="">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @elseif($slide['type'] == 'birthday')
                        <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                            <div class="bg-image w-inherit h-100 position-fixed" style="background-image: url('{{ asset('assets/images/birthday_bg.png') }}'); background-size: cover; background-position: center;">

                                <div class="text-center">
                                    <img class="mb-2 mt-4" width="230px" src="{{ asset('assets/images/zettamine-transparent.png') }}" alt="">
                                    <div>
                                        <h5 class="b-day-text text-center fw-bold pt-1">HAPPY <br> BIRTHDAY </h5>
                                    </div>
                                    <div class="col-md-8 container">
                                        <div class="">
                                            <div class="">
                                                <img class="bday-ballone mx-auto d-block my-auto mt-4" src="{{ asset('assets/images/bday_ballone.png') }}" alt="...">
                                                <img class="embelem mx-auto d-block my-auto mt-4" src="{{ $slide['photo'] ? get_image('uploads/user-image/' . $slide['photo']) : asset('assets/images/bday_person.png') }}" alt="...">
                                                <img class="bday_box mx-auto d-block my-auto mt-4" src="{{ asset('assets/images/bday_box.png') }}" alt="...">
                                                <div class="ribbon mt-4">{{$slide['name']}}</div>
                                                <p class="text-center text-dark pt-3 bday-para">“The whole team wishes you a happy birthday! May your day be filled with joy and laughter."</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($slide['type'] == 'eotm')
                        <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                            <div class="bg-image w-inherit h-100 position-fixed" style="background-image: url('{{ asset('assets/images/golden_bg.png') }}'); background-size: cover; background-position: center;">
                                <div class="text-center">
                                    <img class="mb-4 mt-2" width="230px" src="{{ asset('assets/images/zettamine-transparent.png') }}" alt="">
                                    <div>
                                        <span class="horizontal-line"></span>
                                        <h5 class="text-center fw-bold pt-1" style="color:#A97F40;">EMPLOYEE OF THE <br>
                                            <span style="color:#441904bf;">MONTH</span>
                                        </h5>
                                        <span class="horizontal-line"></span>
                                    </div>

                                </div>
                                <div class="embelem-rean mt-4" style="background-image: url('{{ asset('assets/images/quatar_emblem.png') }}')">
                                    <img class="embelem-profile-pic mx-auto d-block my-auto " src="{{ $slide['photo'] ? get_image('uploads/user-image/' . $slide['photo']) : asset('assets/images/bday_person.png') }}" alt="">
                                </div>
                                <div class="ribbon mt-4">{{$slide['name']}}</div>
                                <p class="text-center text-dark">Thank you for your <br>
                                    <span class="fw-bold"> Your outstanding service</span> <br>
                                    Congratulations
                                </p>
                            </div>
                        </div>
                        @elseif($slide['type'] == 'eotq')
                        <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                            <div class="bg-image w-inherit h-100 position-fixed" style="background-image: url('{{ asset('assets/images/golden_bg.png') }}'); background-size: cover; background-position: center;">
                                <div class="text-center">
                                    <img class="mb-4 mt-2" width="230px" src="{{ asset('assets/images/zettamine-transparent.png') }}" alt="">
                                    <div>
                                        <span class="horizontal-line"></span>
                                        <h5 class="text-center fw-bold pt-1" style="color:#A97F40;">EMPLOYEE OF THE <br>
                                            <span style="color:#441904bf;">QUARTER</span>
                                        </h5>
                                        <span class="horizontal-line"></span>
                                    </div>

                                </div>
                                <div class="embelem-rean mt-4" style="background-image: url('{{ asset('assets/images/quatar_emblem.png') }}')">
                                    <img class="embelem-profile-pic mx-auto d-block my-auto " src="{{ $slide['photo'] ? get_image('uploads/user-image/' . $slide['photo']) : asset('assets/images/bday_person.png') }}" alt="">
                                </div>
                                <div class="ribbon mt-4">{{$slide['name']}}</div>
                                <p class="text-center text-dark">Thank you for your <br>
                                    <span class="fw-bold"> Your outstanding service</span> <br>
                                    Congratulations
                                </p>
                            </div>
                        </div>
                        @elseif($slide['type'] == 'eoty')
                        <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                            <div class="bg-image w-inherit h-100 position-fixed" style="background-image: url('{{ asset('assets/images/golden_bg.png') }}'); background-size: cover; background-position: center;">
                                <div class="text-center">
                                    <img class="mb-4 mt-2" width="230px" src="{{ asset('assets/images/zettamine-transparent.png') }}" alt="">
                                    <div>
                                        <span class="horizontal-line"></span>
                                        <h5 class="text-center fw-bold pt-1" style="color:#A97F40;">EMPLOYEE OF THE <br>
                                            <span style="color:#441904bf;">YEAR</span>
                                        </h5>
                                        <span class="horizontal-line"></span>
                                    </div>

                                </div>
                                <div class="embelem-rean mt-4" style="background-image: url('{{ asset('assets/images/year_emblem.png') }}')">
                                    <img class="embelem-profile-pic mx-auto d-block my-auto " src="{{ $slide['photo'] ? get_image('uploads/user-image/' . $slide['photo']) : asset('assets/images/bday_person.png') }}" alt="">
                                </div>
                                <div class="ribbon mt-4">{{$slide['name']}}</div>
                                <p class="text-center text-dark">Thank you for your <br>
                                    <span class="fw-bold"> Your outstanding service</span> <br>
                                    Congratulations
                                </p>
                            </div>
                        </div>
                        @elseif($slide['type'] == 'lse')
                        <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                            <div class="bg-image w-inherit h-100 position-fixed" style="background-image: url('{{ asset('assets/images/long_service_employee.png') }}'); background-size: cover; background-position: center;">
                                <div class="text-center">
                                    <img class="mb-4 mt-2" width="230px" src="{{ asset('assets/images/zettamine-transparent.png') }}" alt="">
                                    <div>
                                        <span class="horizontal-line"></span>
                                        <h5 class="text-center fw-bold pt-1" style="color:#930b0c;">EMPLOYEE OF THE <br>
                                            <span style="color:#930b0c;">LONG SERVICE</span>
                                        </h5>
                                        <span class="horizontal-line"></span>
                                    </div>

                                </div>
                                <div class="embelem-rean mt-4" style="background-image: url('{{ asset('assets/images/long_service_emblum.png') }}');">
                                    <img class="embelem-profile-pic mx-auto d-block my-auto " src="{{ $slide['photo'] ? get_image('uploads/user-image/' . $slide['photo']) : asset('assets/images/bday_person.png') }}" alt="">
                                </div>


                                <!-- <img class="embelem mx-auto d-block my-auto mt-4" src="{{ asset('assets/images/long_emblem.png') }}" alt=""> -->
                                <div class="ribbon mt-4 fw-bold text-white">{{$slide['name']}}</div>
                                <p class="text-center" style="color: #1b0241;">Thank you for your <br>
                                    <span class="fw-bold"> Your outstanding service</span> <br>
                                    Congratulations
                                </p>
                            </div>
                        </div>
                        @elseif($slide['type'] == 'announcement')
                        <div class="col-lg-6 d-none d-lg-block p-0 h-100">
                            <div class="text-center w-inherit h-100 position-fixed">
                                <img class="mt-2 mb-2" width="230px" src="{{ asset('assets/images/zettamine-transparent.png') }}" alt="">
                                <div class="envelope-image-bg">
                                    <div class="annount-crad">
                                        <h6 class="announcement-heading">{{$slide['subject']}}</h6>
                                        <p class="announcement-para">{{$slide['message']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        @endif
                    </div>
                    @endforeach
                    @endif


                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="col-lg-6 p-0 h-100 position-relative">
                <div class="parent-elem">
                    <div class="middle-elem">
                        <div class="primary-form">
                            <img class="mb-4" width="230px" src="{{ get_image(get_settings('dark_logo')) }}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="subtitle">
                                        <p>{{get_settings('website_tag_line')}}</p>
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
                                                        <input type="email" name="email" class="form-control mb-0" id="email" placeholder="Your email address" value="{{ old('email') }}">
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