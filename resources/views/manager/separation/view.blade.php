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
                <li><a href="{{route('manager.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="{{route('manager.separation')}}">{{ get_phrase('Separation') }}</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">
            <div class="">
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
                            padding: 9px 10px 10px 10px;
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

                        #progressbar li.green:before,
                        #progressbar li.green:after {
                            background: green;
                            color: white;
                        }

                        #progressbar li.blue:before,
                        #progressbar li.blue:after {
                            background: blue;
                            color: white;
                        }

                        #progressbar li.red:before,
                        #progressbar li.red:after {
                            background: red;
                            color: white;
                        }

                        #progressbar li.gray:before,
                        #progressbar li.gray:after {
                            background: gray;
                            color: white;
                        }

                        .gray {
                            pointer-events: none;
                        }

                        .previous {
                            background-color: #d2d4f4;
                            color: black;
                            float: left;
                        }

                        .next {
                            background-color: #04AA6D;
                            color: white;
                            float: right;
                        }

                        a {
                            text-decoration: none;
                            display: inline-block;
                            padding: 8px 16px;
                        }

                        a:hover {
                            background-color: #ddd;
                            color: black;
                        }
                    </style>
                    @php
                    $initiated = $manager = $it_manager = $finance_manager = $hr_manager = "" ;
                    if($separation[0]->status == "Pending at Manager"){
                    $initiated = "green";
                    $manager = "blue";
                    $hr_manager = "gray";
                    $it_manager = "gray";
                    $finance_manager = "gray";
                    }else if($separation[0]->status == "Rejected by Manager"){
                    $initiated = "green";
                    $manager = "red";
                    $hr_manager = "gray";
                    $it_manager = "gray";
                    $finance_manager = "gray";
                    }else if($separation[0]->status == "Approved by Manager" || $separation[0]->status == "Pending at HR Manager"){
                    $initiated = "green";
                    $manager = "green";
                    $hr_manager = "blue";
                    $it_manager = "gray";
                    $finance_manager = "gray";
                    }else if($separation[0]->status == "Rejected by HR Manager"){
                    $initiated = "green";
                    $manager = "green";
                    $hr_manager = "red";
                    $it_manager = "gray";
                    $finance_manager = "gray";
                    }else if($separation[0]->status == "Approved by HR Manager" || $separation[0]->status == "Pending at IT Manager"){
                    $initiated = "green";
                    $manager = "green";
                    $hr_manager = "green";
                    $it_manager = "blue";
                    $finance_manager = "gray";
                    }else if($separation[0]->status == "Rejected by IT Manager"){
                    $initiated = "green";
                    $manager = "green";
                    $hr_manager = "green";
                    $it_manager = "red";
                    $finance_manager = "gray";
                    }else if($separation[0]->status == "Approved by IT Manager" || $separation[0]->status == "Pending at Finance Manager"){
                    $initiated = "green";
                    $manager = "green";
                    $hr_manager = "green";
                    $it_manager = "green";
                    $finance_manager = "blue";
                    }else if($separation[0]->status == "Rejected by Finance Manager"){
                    $initiated = "green";
                    $manager = "green";
                    $hr_manager = "green";
                    $it_manager = "green";
                    $finance_manager = "red";
                    }else if($separation[0]->status == "Approved by Finance Manager"){
                    $initiated = "green";
                    $manager = "green";
                    $hr_manager = "green";
                    $it_manager = "green";
                    $finance_manager = "green";
                    }
                    @endphp
                    <div class="col-md-12 col-md-offset-3">
                        <div id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li onclick="toggleFieldset(0)" class="{{$initiated}}">Initiated</li>
                                <li onclick="toggleFieldset(1)" class="{{$manager}}">Manager</li>
                                <li onclick="toggleFieldset(2)" class="{{$hr_manager}}">HR Manager</li>
                                <li onclick="toggleFieldset(3)" class="{{$it_manager}}">IT Manager</li>
                                <li onclick="toggleFieldset(4)" class="{{$finance_manager}}">Finance Manager</li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset id="fieldset0">
                                <h2 class="fs-title">Separation Details</h2>
                                <div class="d-flex flex-row">
                                    <div class="fpb-7 w-50">
                                        <label for="name" class="eForm-label">{{get_phrase('Employee Name')}}</label>
                                        <input type="text" class="form-control eForm-control" name="name" disabled value="{{ $separation[0]->name}} - ({{$separation[0]->emp_id}})" />
                                    </div>

                                    <div class="fpb-7 mx-5 w-50">
                                        <label for="initiated_date" class="eForm-label">{{get_phrase('Initiated date')}}</label>
                                        <input type="text" class="form-control eForm-control" name="initiated_date" disabled value="{{ date('d, F, Y', strtotime($separation[0]->initiated_date)) }}" />
                                    </div>
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="fpb-7 w-50">
                                        <label for="email" class="eForm-label">{{get_phrase('Actual Last Working Day')}}</label>
                                        <input type="text" class="form-control eForm-control" name="actual_last_working_day" disabled value="{{ date('d, F, Y', strtotime($separation[0]->actual_last_working_day)) }}" />
                                    </div>

                                    <div class="fpb-7 mx-5 w-50">
                                        <label for="user_proposed_last_working_day" class="eForm-label">{{get_phrase('Employee Proposed Last Working Day')}}</label>
                                        <input type="text" class="form-control eForm-control" name="user_proposed_last_working_day" disabled value="{{ $separation[0]->user_proposed_last_working_day ? date('d, F, Y', strtotime($separation[0]->user_proposed_last_working_day)) : '-' }}" />
                                    </div>
                                </div>
                                <div class="fpb-7">
                                    <label for="reason" class="eForm-label">{{get_phrase('Reason')}}</label>
                                    <textarea type="text" name="reason" class="form-control eForm-control" id="reason" disabled>{{$separation[0]->reason}}</textarea>
                                </div>
                                <a href="#" class="next" onclick="toggleFieldset(1)">Next &raquo;</a>

                            </fieldset>
                            <fieldset id="fieldset1" style="display: none;">
                                <h2 class="fs-title">Manager Approval Details</h2>
                                <form action="{{route('manager.separation.manager_approvals')}}" method="post" enctype="multipart/form-data">
                                    @Csrf
                                    @php
                                    $manager_details = App\Models\User::where('id', $separation[0]->manager)->get()->First();
                                    @endphp
                                    <div class="d-flex flex-row">
                                        <input type="hidden" class="eBtn eBtn-red text-white lh-12px" name="id" value="{{$separation[0]->id}}">
                                        <div class="fpb-7 w-50">
                                            <label for="name" class="eForm-label">{{get_phrase('Manager Name')}}</label>
                                            <input type="text" class="form-control eForm-control" name="name" disabled value="{{ $manager_details->name}} - ({{$manager_details->emp_id}})" />
                                        </div>

                                        <div class="fpb-7 mx-5 w-50">
                                            <label for="initiated_date" class="eForm-label">{{get_phrase('Assigned date')}}</label>
                                            <input type="text" class="form-control eForm-control" disabled name="initiated_date" value="{{ date('d, F, Y', strtotime($separation[0]->initiated_date)) }}" />
                                        </div>
                                    </div>
                                    <div class="fpb-7">
                                        <label for="reporting_manager_comments" class="eForm-label">{{get_phrase('Comments')}}</label>
                                        <textarea type="text" name="reporting_manager_comments" class="form-control eForm-control" id="reporting_manager_comments" {{auth()->user()->id == $separation[0]->manager? '' : 'disabled'}}>{{$separation[0]->reporting_manager_comments}}</textarea>
                                    </div>
                                    @if(auth()->user()->id == $separation[0]->manager)

                                    <div class="d-flex flex-row justify-content-center">
                                        <div class="fpb-7 w-20">
                                            <input type="submit" class="eBtn eBtn-green text-white lh-12px" name="action" value="Approve">
                                        </div>
                                        <div class="fpb-7 mx-3 w-20">
                                            <input type="submit" class="eBtn eBtn-red text-white lh-12px" name="action" value="Reject">
                                        </div>
                                    </div>
                                    @endif

                                    <a href="#" class="previous" onclick="toggleFieldset(0)">&laquo; Previous</a>
                                    <a href="#" class="next {{$hr_manager}}" onclick="toggleFieldset(2)">Next &raquo;</a>
                                </form>

                            </fieldset>
                            <fieldset id="fieldset2" style="display: none;">
                                <h2 class="fs-title">HR Manager Approval Details</h2>
                                <form action="{{route('manager.separation.hr_manager_approvals')}}" method="post" enctype="multipart/form-data">
                                    @Csrf
                                    @php
                                    $hr_manager_details = App\Models\User::where('email', 'hr@zettamine.com')->get()->First();
                                    @endphp
                                    <div class="d-flex flex-row">
                                        <input type="hidden" class="eBtn eBtn-green text-white lh-12px" name="id" value="{{$separation[0]->id}}">
                                        <div class="fpb-7 w-50">
                                            <label for="name" class="eForm-label">{{get_phrase('HR Manager Name')}}</label>
                                            <input type="text" class="form-control eForm-control" name="name" disabled value="{{ $hr_manager_details->name}} - ({{$hr_manager_details->emp_id}})" />
                                        </div>

                                        <div class="fpb-7 mx-5 w-50">
                                            <label for="reporting_manager_approved_or_rejected_date" class="eForm-label">{{get_phrase('Assigned date')}}</label>
                                            <input type="text" class="form-control eForm-control" disabled name="reporting_manager_approved_or_rejected_date" value="{{ date('d, F, Y', strtotime($separation[0]->reporting_manager_approved_or_rejected_date)) }}" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row">
                                        <div class="fpb-7 w-50">
                                            <label for="hr_proposed_last_working_day" class="eForm-label">{{get_phrase('Propose a last working date')}}</label>
                                            <input type="date" class="form-control eForm-control" name="hr_proposed_last_working_day" {{auth()->user()->email == 'hr@zettamine.com'? '' : 'disabled'}} value="{{ date('Y-m-d', strtotime($separation[0]->hr_proposed_last_working_day)) }}" />
                                        </div>


                                    </div>
                                    <div class="fpb-7">
                                        <label for="hr_manager_comments" class="eForm-label">{{get_phrase('Comments')}}</label>
                                        <textarea type="text" name="hr_manager_comments" class="form-control eForm-control" id="hr_manager_comments" {{auth()->user()->email == 'hr@zettamine.com'? '' : 'disabled'}}>{{$separation[0]->hr_manager_comments}}</textarea>
                                    </div>
                                    @if(auth()->user()->email == 'hr@zettamine.com')
                                    <div class="d-flex flex-row">
                                        <div class="fpb-7 w-20">
                                            <input type="submit" class="eBtn eBtn-green text-white lh-12px" name="action" value="Approve">
                                        </div>
                                        <div class="fpb-7 mx-5 w-20">
                                            <input type="submit" class="eBtn eBtn-red text-white lh-12px" name="action" value="Reject">
                                        </div>
                                    </div>
                                    @endif
                                    <a href="#" class="previous" onclick="toggleFieldset(1)">&laquo; Previous</a>
                                    <a href="#" class="next {{$it_manager}}" onclick="toggleFieldset(3)">Next &raquo;</a>
                                </form>
                            </fieldset>
                            <fieldset id="fieldset3" style="display: none;">
                                <h2 class="fs-title">IT Manager Approval Details</h2>
                                <form action="{{route('manager.separation.it_manager_approvals')}}" method="post" enctype="multipart/form-data">
                                    @Csrf
                                    @php
                                    $it_manager_details = App\Models\User::where('email', 'it@zettamine.com')->get()->First();
                                    @endphp
                                    <div class="d-flex flex-row">
                                        <input type="hidden" class="eBtn eBtn-green text-white lh-12px" name="id" value="{{$separation[0]->id}}">
                                        <div class="fpb-7 w-50">
                                            <label for="name" class="eForm-label">{{get_phrase('IT Manager Name')}}</label>
                                            <input type="text" class="form-control eForm-control" name="name" disabled value="{{ $it_manager_details->name}} - ({{$it_manager_details->emp_id}})" />
                                        </div>

                                        <div class="fpb-7 mx-5 w-50">
                                            <label for="hr_manager_approved_or_rejected_date" class="eForm-label">{{get_phrase('Assigned date')}}</label>
                                            <input type="text" class="form-control eForm-control" disabled name="hr_manager_approved_or_rejected_date" value="{{ date('d, F, Y', strtotime($separation[0]->hr_manager_approved_or_rejected_date)) }}" />
                                        </div>
                                    </div>
                                    <div class="fpb-7">
                                        <label for="it_manager_comments" class="eForm-label">{{get_phrase('Comments')}}</label>
                                        <textarea type="text" name="it_manager_comments" class="form-control eForm-control" id="it_manager_comments" {{auth()->user()->email == 'it@zettamine.com'? '' : 'disabled'}}>{{$separation[0]->it_manager_comments}}</textarea>
                                    </div>
                                    @if(auth()->user()->email == 'it@zettamine.com')
                                    <div class="d-flex flex-row">
                                        <div class="fpb-7 w-20">
                                            <input type="submit" class="eBtn eBtn-green text-white lh-12px" name="action" value="Approve">
                                        </div>
                                        <div class="fpb-7 mx-5 w-20">
                                            <input type="submit" class="eBtn eBtn-red text-white lh-12px" name="action" value="Reject">
                                        </div>
                                    </div>
                                    @endif

                                    <a href="#" class="previous" onclick="toggleFieldset(2)">&laquo; Previous</a>
                                    <a href="#" class="next {{$finance_manager}}" onclick="toggleFieldset(4)">Next &raquo;</a>
                                </form>
                            </fieldset>
                            <fieldset id="fieldset4" style="display: none;">
                                <h2 class="fs-title">Finance Manager Approval Details</h2>
                                <form action="{{route('manager.separation.finance_manager_approvals')}}" method="post" enctype="multipart/form-data">
                                    @Csrf
                                    @php
                                    $finance_manager_details = App\Models\User::where('email', 'accounts@zettamine.com')->get()->First();
                                    @endphp
                                    <div class="d-flex flex-row">
                                        <input type="hidden" class="eBtn eBtn-green text-white lh-12px" name="id" value="{{$separation[0]->id}}">
                                        <div class="fpb-7 w-50">
                                            <label for="name" class="eForm-label">{{get_phrase('Finance Manager Name')}}</label>
                                            <input type="text" class="form-control eForm-control" name="name" disabled value="{{ $finance_manager_details->name}} - ({{$finance_manager_details->emp_id}})" />
                                        </div>

                                        <div class="fpb-7 mx-5 w-50">
                                            <label for="it_manager_approved_or_rejected_date" class="eForm-label">{{get_phrase('Assigned date')}}</label>
                                            <input type="text" class="form-control eForm-control" disabled name="it_manager_approved_or_rejected_date" value="{{ date('d, F, Y', strtotime($separation[0]->it_manager_approved_or_rejected_date)) }}" />
                                        </div>
                                    </div>
                                    <div class="fpb-7">
                                        <label for="finance_manager_comments" class="eForm-label">{{get_phrase('Comments')}}</label>
                                        <textarea type="text" name="finance_manager_comments" class="form-control eForm-control" id="finance_manager_comments" {{auth()->user()->email == 'accounts@zettamine.com'? '' : 'disabled'}}>{{$separation[0]->finance_manager_comments}}</textarea>
                                    </div>
                                    @if(auth()->user()->email == 'accounts@zettamine.com')
                                    <div class="d-flex flex-row">
                                        <div class="fpb-7 w-20">
                                            <input type="submit" class="eBtn eBtn-green text-white lh-12px" name="action" value="Approve">
                                        </div>
                                        <div class="fpb-7 mx-5 w-20">
                                            <input type="submit" class="eBtn eBtn-red text-white lh-12px" name="action" value="Reject">
                                        </div>
                                    </div>
                                    @endif

                                    <a href="#" class="previous" onclick="toggleFieldset(3)">&laquo; Previous</a>
                                </form>
                            </fieldset>

                        </div>
                    </div>
                </div>
                <!-- /.MultiStep Form -->
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    let currentVisibleIndex = 0;

    function toggleFieldset(index) {
        // Hide the currently visible fieldset
        document.getElementById('fieldset' + currentVisibleIndex).style.display = 'none';

        // Show the newly selected fieldset
        document.getElementById('fieldset' + index).style.display = 'block';

        // Update the current visible index
        currentVisibleIndex = index;
    }
    toggleFieldset(0);
</script>