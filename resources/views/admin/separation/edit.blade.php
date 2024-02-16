@extends('index')
@push('title', get_phrase('Separation View'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

<div class="mainSection-title">

    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Separation') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="{{route('admin.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="{{route('admin.separation')}}">{{ get_phrase('Separation') }}</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">
            <p class="column-title mb-2">{{get_phrase('Separation')}}</p>
            <div class="table-responsive">
                <!-- MultiStep Form -->
                <div class="row">
                    <style>
                        /*custom font*/
                        @import url(https://fonts.googleapis.com/css?family=Montserrat);

                        /*basic reset*/



                        /*form styles*/
                        #msform {
                            text-align: center;
                            position: relative;
                            margin-top: 30px;
                        }

                        #msform fieldset {
                            background: white;
                            border: 0 none;
                            border-radius: 8px;
                            box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
                            padding: 20px 30px;
                            box-sizing: border-box;
                            width: 80%;
                            margin: 0 10%;

                            /*stacking fieldsets above each other*/
                            position: relative;
                        }

                        /*Hide all except first fieldset*/
                        #msform fieldset:not(:first-of-type) {
                            display: none;
                        }

                        /*inputs*/
                        #msform input,
                        #msform textarea {
                            padding: 15px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            margin-bottom: 10px;
                            width: 100%;
                            box-sizing: border-box;
                            font-family: montserrat;
                            color: #2C3E50;
                            font-size: 13px;
                        }

                        #msform input:focus,
                        #msform textarea:focus {
                            -moz-box-shadow: none !important;
                            -webkit-box-shadow: none !important;
                            box-shadow: none !important;
                            border: 1px solid #2098ce;
                            outline-width: 0;
                            transition: All 0.5s ease-in;
                            -webkit-transition: All 0.5s ease-in;
                            -moz-transition: All 0.5s ease-in;
                            -o-transition: All 0.5s ease-in;
                        }

                        /*buttons*/
                        #msform .action-button {
                            width: 100px;
                            background: #2098ce;
                            font-weight: bold;
                            color: white;
                            border: 0 none;
                            border-radius: 25px;
                            cursor: pointer;
                            padding: 10px 5px;
                            margin: 10px 5px;
                        }

                        #msform .action-button:hover,
                        #msform .action-button:focus {
                            box-shadow: 0 0 0 2px white, 0 0 0 3px #2098ce;
                        }

                        #msform .action-button-previous {
                            width: 100px;
                            background: #aCbEd0;
                            font-weight: bold;
                            color: white;
                            border: 0 none;
                            border-radius: 25px;
                            cursor: pointer;
                            padding: 10px 5px;
                            margin: 10px 5px;
                        }

                        #msform .action-button-previous:hover,
                        #msform .action-button-previous:focus {
                            box-shadow: 0 0 0 2px white, 0 0 0 3px #aCbEd0;
                        }

                        /*headings*/
                        .fs-title {
                            font-size: 18px;
                            text-transform: uppercase;
                            color: #2C3E50;
                            margin-bottom: 10px;
                            letter-spacing: 2px;
                            font-weight: bold;
                        }

                        .fs-subtitle {
                            font-weight: normal;
                            font-size: 13px;
                            color: #666;
                            margin-bottom: 20px;
                        }

                        /*progressbar*/
                        #progressbar {
                            margin-bottom: 30px;
                            overflow: hidden;
                            /*CSS counters to number the steps*/
                            counter-reset: step;
                        }

                        #progressbar li {
                            list-style-type: none;
                            color: #666;
                            text-transform: uppercase;
                            font-size: 9px;
                            width: 20%;
                            float: left;
                            position: relative;
                            letter-spacing: 1px;
                        }

                        #progressbar li:before {
                            content: counter(step);
                            counter-increment: step;
                            width: 24px;
                            height: 24px;
                            line-height: 26px;
                            display: block;
                            font-size: 12px;
                            color: #333;
                            background: white;
                            border-radius: 25px;
                            margin: 0 auto 10px auto;
                        }

                        /*progressbar connectors*/
                        #progressbar li:after {
                            content: '';
                            width: 100%;
                            height: 2px;
                            background: white;
                            position: absolute;
                            left: -50%;
                            top: 9px;
                            z-index: -1;
                            /*put it behind the numbers*/
                        }

                        #progressbar li:first-child:after {
                            /*connector not needed before the first step*/
                            content: none;
                        }

                        /*marking active/completed steps blue*/
                        /*The number of the step and the connector before it = blue*/
                        #progressbar li.active:before,
                        #progressbar li.active:after {
                            background: #2098ce;
                            color: white;
                        }
                    </style>
                    <div class="col-md-12 col-md-offset-3">
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active">Initiated</li>
                                <li>Manager</li>
                                <li>IT Manager</li>
                                <li>Finance Manager</li>
                                <li>HR Manager</li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <h2 class="fs-title">Separation Details</h2>
                                
                                <div class="fpb-7">
                                    <label for="reason" class="eForm-label">{{get_phrase('Reason')}}</label>
                                    <textarea type="text" name="reason" class="form-control eForm-control" id="reason" disabled>{{$separation->reason}}</textarea>
                                </div>

                                <div class="fpb-7">
                                    <label for="email" class="eForm-label">{{get_phrase('Actual Last Working Day')}} - {{$separation->actual_last_working_day}} - {{ date('m/d/Y', strtotime($separation->actual_last_working_day)) }}</label>
                                    <input type="date" class="form-control eForm-control date-range-picket" name="actual_last_working_day" value="{{ date('m/d/Y', strtotime($separation->actual_last_working_day)) }}" />
                                </div>

                                <div class="fpb-7">
                                    <label for="user_proposed_last_working_day" class="eForm-label">{{get_phrase('Proposed Last Working Day')}}</label>
                                    <input type="date" class="form-control eForm-control date-range-picket" id="eInputDate" name="user_proposed_last_working_day" value="{{ $separation->user_proposed_last_working_day }}" />
                                </div>



                            </fieldset>
                            <fieldset>
                                <h2 class="fs-title">Social Profiles</h2>
                                <h3 class="fs-subtitle">Your presence on the social network</h3>
                                <input type="text" name="twitter" placeholder="Twitter" />
                                <input type="text" name="facebook" placeholder="Facebook" />
                                <input type="text" name="gplus" placeholder="Google Plus" />
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="button" name="next" class="next action-button" value="Next" />
                            </fieldset>
                            <fieldset>
                                <h2 class="fs-title">Create your account</h2>
                                <h3 class="fs-subtitle">Fill in your credentials</h3>
                                <input type="text" name="email" placeholder="Email" />
                                <input type="password" name="pass" placeholder="Password" />
                                <input type="password" name="cpass" placeholder="Confirm Password" />
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="submit" name="submit" class="submit action-button" value="Submit" />
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- /.MultiStep Form -->
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    //jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    $(".next").click(function() {
        if (animating) return false;
        animating = true;

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'position': 'absolute'
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".previous").click(function() {
        if (animating) return false;
        animating = true;

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1 - now) * 50) + "%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'left': left
                });
                previous_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".submit").click(function() {
        return false;
    })
</script>