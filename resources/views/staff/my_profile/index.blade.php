@extends('index')
@push('title', get_phrase('My Profile'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('My profile') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{route('admin.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('My profile') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Start User Profile area -->
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <!-- Left side -->
            <div class="user-profile-area">
                <div class="user-info d-flex flex-column mw-unset">
                    <div class="user-info-basic d-flex flex-column justify-content-center">
                        <div class="user-graphic-element-1">
                            <img src="{{ get_image('assets/images/sprial_1.png') }}" alt="" />
                        </div>
                        <div class="user-graphic-element-2">
                            <img src="{{ get_image('assets/images/polygon_1.png') }}" alt="" />
                        </div>
                        <div class="user-graphic-element-3">
                            <img src="{{ get_image('assets/images/circle_1.png') }}" alt="" />
                        </div>
                        <div class="userImg">
                            <img width="100%" src="{{ get_image('uploads/user-image/' . $user->photo) }}" alt="" />
                        </div>
                        <div class="userContent text-center">
                            <h4 class="title">{{ $user->name }}</h4>
                            <p class="info">{{ $user->designation }}</p>
                            <p class="user-status-verify">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>
                    <div class="user-info-edit">
                        <div class="user-edit-title d-flex justify-content-between align-items-center">
                            <h3 class="title">{{ get_phrase('Details info') }}</h3>
                        </div>
                        <div class="user-info-edit-items">
                            <div class="item">
                                <p class="title">{{ get_phrase('Email') }}</p>
                                <p class="info">{{ $user->email }}</p>
                            </div>

                            @if ($user->phone)
                                <div class="item">
                                    <p class="title">{{ get_phrase('Phone Number') }}</p>
                                    <p class="info">{{ $user->phone }}</p>
                                </div>
                            @endif

                            @if ($user->present_address)
                                <div class="item">
                                    <p class="title">{{ get_phrase('Present Address') }}</p>
                                    <p class="info">{{ $user->present_address }}</p>
                                </div>
                            @endif

                            @if ($user->gender)
                                <div class="item">
                                    <p class="title">{{ get_phrase('Gender') }}</p>
                                    <p class="info">{{ ucfirst($user->gender) }}</p>
                                </div>
                            @endif

                            @if ($user->blood_group)
                                <div class="item">
                                    <p class="title">{{ get_phrase('Blood group') }}</p>
                                    <p class="info">{{ $user->blood_group }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xl-9">
            <!-- Right side -->
            <div class="user-profile-area">
                <div class="user-details-info mw-unset">
                    <!-- Tab label -->
                    <ul class="nav nav-tabs eNav-Tabs-custom" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['info'])}}');" class="nav-link @if($tab == 'info') active @endif" type="button">
                                {{ get_phrase('Basic Info') }}
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['task'])}}');" class="nav-link  @if($tab == 'task') active @endif" type="button">
                                Task
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['attendance'])}}');" class="nav-link @if($tab == 'attendance') active @endif" type="button">
                                Attendance
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['timesheet'])}}');" class="nav-link @if($tab == 'timesheet') active @endif" type="button">
                                Timesheet
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['payslip'])}}');" class="nav-link @if($tab == 'payslip') active @endif" type="button">
                                Payslip
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['assessment'])}}');" class="nav-link @if($tab == 'assessment') active @endif" type="button">
                                Assessment
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['performance'])}}');" class="nav-link @if($tab == 'performance') active @endif" type="button">
                                Performance
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['leave'])}}');" class="nav-link @if($tab == 'leave') active @endif" type="button">
                                Leave
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button onclick="redirectTo('{{route('staff.my.profile', ['inventory'])}}');" class="nav-link @if($tab == 'inventory') active @endif" type="button">
                                {{get_phrase('Inventory')}}
                                <span></span>
                            </button>
                        </li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content eNav-Tabs-content" id="myTabContent">
                        <div class="tab-pane fade show active">
                            <div class="eForm-layouts">
                                @include('staff.my_profile.profile_' . $tab)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End User Profile area -->
@endsection
