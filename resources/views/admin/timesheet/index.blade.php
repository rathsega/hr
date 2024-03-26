@extends('index')
@push('title', get_phrase('Timesheet'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Timesheet') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Timesheet') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2">
            <div class="eSection-wrap">
                <div class="row">
                    <div class="col-md-12">
                        @if (isset($_GET['id']) && $_GET['id'] > 0)
                            @include('admin.timesheet.edit')
                        @else
                            @include('admin.timesheet.add')
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 order-md-1">
            <div class="eSection-wrap">
                <div class="row">

                    @php
                        if (isset($_GET['year'])) {
                            $selected_year = $_GET['year'];
                        } else {
                            $selected_year = date('Y');
                        }
                        
                        if (isset($_GET['month'])) {
                            $selected_month = $_GET['month'];
                        } else {
                            $selected_month = date('m');
                        }
                        
                        $timestamp_of_first_date = strtotime($selected_year . '-' . $selected_month . '-1');
                        $total_days_of_this_month = date('t', $timestamp_of_first_date);
                    @endphp
                    <div class="col-md-12">
                        <form action="{{ route('admin.timesheet') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="eForm-label">{{ get_phrase('Selected Year') }}</label>
                                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select select2">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}" @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="eForm-label">{{ get_phrase('Selected Month') }}</label>
                                    <select onchange="$('#filterForm').submit();" name="month" class="form-select eForm-select select2">
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ $month }}" @if ($selected_month == $month) selected @endif>
                                                {{ date('F', strtotime($year . '-' . $month . '-20')) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-12 pb-4">
                        <div class="accordion custom-accordion" id="accordionExample">
                            @php
                                $counter = 0;
                            @endphp
                            @for ($day = $total_days_of_this_month; $day >= 1; $day--)
                                @php
                                    $start_timestamp = strtotime($selected_year . '-' . $selected_month . '-' . $day . ' 00:00:00');
                                    $end_timestamp = strtotime($selected_year . '-' . $selected_month . '-' . $day . ' 23:59:59');
                                    
                                    $timesheet_staffs = App\Models\Timesheet::join('users', 'users.id', '=', 'timesheets.user_id')
                                        ->where('timesheets.from_date', '>=', $start_timestamp)
                                        ->where('timesheets.to_date', '<=', $end_timestamp)
                                        ->select('timesheets.user_id', DB::raw('count(*) as user_work_list'))
                                        ->groupBy('timesheets.user_id')
                                        ->orderBy('users.sort');
                                    if ($timesheet_staffs->count() == 0) {
                                        continue;
                                    } else {
                                        $counter += 1;
                                    }
                                    
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button @if ($counter > 1) collapsed @endif" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseaccordion{{ $day }}" aria-expanded="@if ($counter == 1) true @else false @endif"
                                            aria-controls="collapseaccordion{{ $day }}">
                                            {{ date('d M - l', $start_timestamp) }}
                                        </button>
                                    </h2>
                                    <div id="collapseaccordion{{ $day }}" class="accordion-collapse collapse @if ($counter == 1) show @endif"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="table-responsive">
                                                <table class="table eTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Employee</th>
                                                            <th class="text-center">{{get_phrase('Date')}}</th>
                                                            <th>{{get_phrase('Description')}}</th>
                                                            <th class="text-center">{{get_phrase('Status')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($timesheet_staffs->get() as $timesheet_staff)
                                                            @php
                                                                $staff = App\Models\User::find($timesheet_staff->user_id);
                                                                $timesheets = DB::table('timesheets')
                                                                    ->where('user_id', $staff->id)
                                                                    ->where('from_date', '>=', $start_timestamp)
                                                                    ->where('to_date', '<=', $end_timestamp)
                                                                    ->get();
                                                            @endphp

                                                            @foreach ($timesheets as $key => $timesheet)
                                                                <tr id="work-update{{ $timesheet->id }}">
                                                                    @if ($key == 0)
                                                                        <td class="text-13px text-dark text-center align-baseline w-130px w-100" rowspan="{{ $timesheets->count() }}">
                                                                            <img class="rounded-circle mt-2" src="{{ get_image('uploads/user-image/' . $staff->photo) }}"
                                                                                width="30px">
                                                                            <p class="p-0 m-0 text-dark">{{ $staff->name }}</p>
                                                                            <p class="text-13px p-0 text-center mb-2">
                                                                                <span class="badge bg-secondary" title="{{ get_phrase('Working time') }}" data-bs-toggle="tooltip">
                                                                                    @php
                                                                                        $total_working_time = $timesheets->sum('working_time');
                                                                                        $hr = gmdate('G', $total_working_time);
                                                                                        $min = gmdate('i', $total_working_time);
                                                                                        if ($hr > 0) {
                                                                                            echo $hr . 'hr ';
                                                                                        }
                                                                                        if ($min > 0) {
                                                                                            echo $min . 'min';
                                                                                        }
                                                                                    @endphp
                                                                                </span>
                                                                            </p>
                                                                        </td>
                                                                    @endif
                                                                    <td class="text-12px text-start align-baseline w-160px p-0">
                                                                        {{ date('h:i a', $timesheet->from_date) }} - {{ date('h:i a', $timesheet->to_date) }}
                                                                        @if ($timesheet->location)
                                                                            <span class="" title="{{ $timesheet->location }}" data-bs-toggle="tooltip">
                                                                                <svg id="fi_9062151" height="15" viewBox="500 50 90 900" width="10"
                                                                                    xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                                                                                    <g stroke="rgb(0,0,0)" stroke-miterlimit="10">
                                                                                        <path
                                                                                            d="m500 843.54a16 16 0 0 1 -13.83-8c-.57-1-57.51-98.94-114.89-201.5-117.18-209.47-122.07-233.92-123.67-242l-.06-.3-1.55-8.63c0-.09 0-.18 0-.28a260.4 260.4 0 0 1 -3.33-41.43 257.4 257.4 0 1 1 514.8 0 260.4 260.4 0 0 1 -3.33 41.43c0 .1 0 .19-.05.28l-1.57 8.71-.06.3c-1.6 8-6.49 32.49-123.67 242-57.45 102.52-114.39 200.48-114.96 201.46a16 16 0 0 1 -13.83 7.96zm-221-457.54c1.78 8.54 17.17 48.3 120.2 232.49 40.31 72 80.4 141.82 100.79 177.14 20.4-35.33 60.5-105.12 100.81-177.18 103.03-184.18 118.41-223.94 120.2-232.45l1.51-8.39a227.58 227.58 0 0 0 2.9-36.18c-.01-124.31-101.12-225.43-225.41-225.43s-225.4 101.12-225.4 225.4a227.58 227.58 0 0 0 2.9 36.18z">
                                                                                        </path>
                                                                                        <path
                                                                                            d="m500 479.77c-85 0-154.2-69.18-154.2-154.2s69.2-154.2 154.2-154.2 154.2 69.17 154.2 154.2-69.2 154.2-154.2 154.2zm0-276.4a122.2 122.2 0 1 0 122.2 122.2 122.33 122.33 0 0 0 -122.2-122.2z">
                                                                                        </path>
                                                                                        <path
                                                                                            d="m500 916c-114.53 0-230.47-30.39-230.47-88.46 0-16.9 10.35-41.23 59.66-61.21 33.18-13.45 78.9-22.64 128.77-25.89a16 16 0 1 1 2.04 31.93c-46.54 3-88.74 11.42-118.83 23.61-29.28 11.87-39.68 24.42-39.68 31.56 0 9.22 16.06 24 51.94 36.08 38.94 13.14 90.98 20.38 146.57 20.38s107.63-7.24 146.53-20.38c35.88-12.13 51.94-26.86 51.94-36.08 0-7.14-10.4-19.69-39.68-31.56-30.09-12.19-72.29-20.57-118.79-23.61a16 16 0 1 1 2-31.93c49.87 3.25 95.59 12.44 128.77 25.89 49.31 20 59.66 44.31 59.66 61.21.04 58.07-115.9 88.46-230.43 88.46z">
                                                                                        </path>
                                                                                    </g>
                                                                                </svg>
                                                                            </span>
                                                                        @endif
                                                                        <span class="" title="{{ $timesheet->device }}" data-bs-toggle="tooltip">
                                                                            @if (str_contains($timesheet->device, 'Mobile'))
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0"
                                                                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                                                    <g>
                                                                                        <path
                                                                                            d="M314.355 461.08a8 8 0 0 1-8 8h-101.57a8 8 0 0 1 0-16h101.57a8 8 0 0 1 8 8zm91.02-416.91v423.67c0 24.35-21.59 44.16-48.12 44.16h-202.51c-26.54 0-48.12-19.81-48.12-44.16V44.17c0-24.35 21.58-44.17 48.12-44.17h202.51c26.53 0 48.12 19.82 48.12 44.17zm-16 0c0-15.53-14.41-28.17-32.12-28.17h-47.57v17.49a8 8 0 0 1-8 8h-96.67a8 8 0 0 1-8-8V16h-42.27c-17.72 0-32.12 12.64-32.12 28.17v423.67c0 15.53 14.4 28.16 32.12 28.16h202.51c17.71 0 32.12-12.63 32.12-28.16z"
                                                                                            fill="#000000" data-original="#000000"></path>
                                                                                    </g>
                                                                                </svg>
                                                                            @elseif (str_contains($timesheet->device, 'Tablet'))
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0"
                                                                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                                                    <g>
                                                                                        <path
                                                                                            d="M242.286 36.571h27.429v18.286h-27.429zM256 420.571c-17.643 0-32 14.357-32 32s14.357 32 32 32 32-14.357 32-32-14.357-32-32-32zm0 45.715c-7.563 0-13.714-6.152-13.714-13.714s6.152-13.714 13.714-13.714 13.714 6.152 13.714 13.714-6.151 13.714-13.714 13.714z"
                                                                                            fill="#000000" data-original="#000000" class=""></path>
                                                                                        <path
                                                                                            d="M406.804 0H105.196C79.964 0 59.429 20.478 59.429 45.647v420.705c0 25.17 20.536 45.647 45.768 45.647h301.607c25.232 0 45.768-20.478 45.768-45.647V45.647C452.571 20.478 432.036 0 406.804 0zm27.482 466.353c0 15.089-12.33 27.362-27.482 27.362H105.196c-15.152 0-27.482-12.272-27.482-27.362V45.647c0-15.089 12.33-27.362 27.482-27.362h301.607c15.152 0 27.482 12.272 27.482 27.362v420.706z"
                                                                                            fill="#000000" data-original="#000000" class=""></path>
                                                                                    </g>
                                                                                </svg>
                                                                            @else
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0"
                                                                                    y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                                                                    xml:space="preserve" class="">
                                                                                    <g>
                                                                                        <path
                                                                                            d="M476 48H36A28.031 28.031 0 0 0 8 76v296a28.031 28.031 0 0 0 28 28h162.24l-4.8 24H160a8 8 0 0 0-8 8v24a8 8 0 0 0 8 8h192a8 8 0 0 0 8-8v-24a8 8 0 0 0-8-8h-33.44l-4.8-24H476a28.031 28.031 0 0 0 28-28V76a28.031 28.031 0 0 0-28-28ZM344 440v8H168v-8Zm-134.24-16 4.8-24h82.88l4.8 24ZM488 372a12.01 12.01 0 0 1-12 12H36a12.01 12.01 0 0 1-12-12v-20h464Zm0-36H24V76a12.01 12.01 0 0 1 12-12h440a12.01 12.01 0 0 1 12 12Z"
                                                                                            fill="#000000" data-original="#000000" class=""></path>
                                                                                        <path d="M264 360h-16a8 8 0 0 0 0 16h16a8 8 0 0 0 0-16Z" fill="#000000"
                                                                                            data-original="#000000" class=""></path>
                                                                                    </g>
                                                                                </svg>
                                                                            @endif
                                                                        </span>
                                                                    </td>
                                                                    <td class="ps-3 align-baseline p-0">
                                                                        {!! script_checker($timesheet->description) !!}
                                                                    </td>
                                                                    <td>
                                                                        @if ($timesheet->status == 'pending')
                                                                            <span class="badge bg-danger">{{get_phrase('Pending')}}</span>
                                                                        @elseif($timesheet->status == 'manager_rejected')
                                                                            <span class="badge bg-secondary">{{get_phrase('Manager Rejected')}}</span>
                                                                        @elseif($timesheet->status == 'hr_rejected')
                                                                            <span class="badge bg-secondary">{{get_phrase('HR Rejected')}}</span>
                                                                        @elseif($timesheet->status == 'manager_approved')
                                                                            <span class="badge bg-secondary">{{get_phrase('Manager Approved')}}</span>
                                                                        @elseif($timesheet->status == 'hr_approved')
                                                                            <span class="badge bg-success">{{get_phrase('HR Approved')}}</span>
                                                                        @else
                                                                            <span class="badge bg-danger">{{get_phrase('Pending')}}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="p-0 ">
                                                                        <div class="invisible-layout">
                                                                        @if($timesheet->user_id  == auth()->user()->id)
                                                                            <a href="{{ route('admin.timesheet', ['id' => $timesheet->id]) }}" class="btn btn p-1"
                                                                                title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0"
                                                                                    y="0" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512 512"
                                                                                    xml:space="preserve" class="">
                                                                                    <g>
                                                                                        <path
                                                                                            d="m496.063 62.299-46.396-46.4c-21.199-21.199-55.689-21.198-76.888 0L27.591 361.113c-2.17 2.17-3.624 5.054-4.142 7.875L.251 494.268a15.002 15.002 0 0 0 17.48 17.482L143 488.549c2.895-.54 5.741-2.008 7.875-4.143l345.188-345.214c21.248-21.248 21.251-55.642 0-76.893zM33.721 478.276l14.033-75.784 61.746 61.75-75.779 14.034zm106.548-25.691L59.41 371.721 354.62 76.488l80.859 80.865-295.21 295.232zM474.85 117.979l-18.159 18.161-80.859-80.865 18.159-18.161c9.501-9.502 24.96-9.503 34.463 0l46.396 46.4c9.525 9.525 9.525 24.939 0 34.465z"
                                                                                            fill="#000000" data-original="#000000" class=""></path>
                                                                                    </g>
                                                                                </svg>
                                                                            </a>

                                                                            <a href="#" onclick="confirmModal('{{ route('admin.timesheet.delete', $timesheet->id) }}')"
                                                                                class="btn btn p-1" title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip"
                                                                                data-bs-placement="top">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="15"
                                                                                    height="15" viewBox="0 0 24 24">
                                                                                    <path
                                                                                        d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
                                                                                    </path>
                                                                                    <path d="M20,4H16V2a1,1,0,0,0-1-1H9A1,1,0,0,0,8,2V4H4A1,1,0,0,0,4,6H20a1,1,0,0,0,0-2ZM10,4V3h4V4Z">
                                                                                    </path>
                                                                                    <path d="M11,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                                                    <path d="M15,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                                                </svg>
                                                                            </a>
                                                                            @endif
                                                                            @if (($timesheet->status == 'manager_approved' || $timesheet->status == 'hr_rejected') && ($timesheet->user_id != auth()->user()->id))
                                                                                <a href="#"
                                                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.timesheet.timesheet_accept_form', 'id' => $timesheet->id]) }}', '{{ get_phrase('Send message') }}')"
                                                                                    class="btn btn p-0" title="{{ get_phrase('Approve') }}" data-bs-placement="right"
                                                                                    data-bs-toggle="tooltip">
                                                                                    <svg height="15" viewBox="0 0 520 520" width="15" xmlns="http://www.w3.org/2000/svg"
                                                                                        id="fi_5291043">
                                                                                        <g id="_7-Check" data-name="7-Check">
                                                                                            <path
                                                                                                d="m79.423 240.755a47.529 47.529 0 0 0 -36.737 77.522l120.73 147.894a43.136 43.136 0 0 0 36.066 16.009c14.654-.787 27.884-8.626 36.319-21.515l250.787-403.892c.041-.067.084-.134.128-.2 2.353-3.613 1.59-10.773-3.267-15.271a13.321 13.321 0 0 0 -19.362 1.343q-.135.166-.278.327l-252.922 285.764a10.961 10.961 0 0 1 -15.585.843l-83.94-76.386a47.319 47.319 0 0 0 -31.939-12.438z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </svg>
                                                                                </a>
                                                                            @endif

                                                                            @if (($timesheet->status == 'hr_approved' || $timesheet->status == 'manager_approved') && ($timesheet->user_id != auth()->user()->id))
                                                                                <a href="#"
                                                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.timesheet.timesheet_rejection_form', 'id' => $timesheet->id]) }}', '{{ get_phrase('Send a reason for this rejection') }}')"
                                                                                    class="btn btn p-1" title="{{ get_phrase('Reject') }}" data-bs-placement="right"
                                                                                    data-bs-toggle="tooltip">
                                                                                    <svg id="fi_8867452" enable-background="new 0 0 512 512" height="15" viewBox="0 0 512 512"
                                                                                        width="15" xmlns="http://www.w3.org/2000/svg">
                                                                                        <g>
                                                                                            <path
                                                                                                d="m256 0c-141.163 0-256 114.837-256 256s114.837 256 256 256 256-114.837 256-256-114.837-256-256-256zm111.963 331.762c10 10 10 26.212 0 36.212-5 4.988-11.55 7.487-18.1 7.487s-13.1-2.5-18.1-7.487l-75.763-75.774-75.762 75.775c-5 4.988-11.55 7.487-18.1 7.487s-13.1-2.5-18.1-7.487c-10-10-10-26.212 0-36.212l75.762-75.763-75.762-75.762c-10-10-10-26.213 0-36.213 10-9.988 26.2-9.988 36.2 0l75.762 75.775 75.762-75.775c10-9.988 26.2-9.988 36.2 0 10 10 10 26.213 0 36.213l-75.762 75.762z">
                                                                                            </path>
                                                                                        </g>
                                                                                    </svg>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                $('.current-location-form').prepend('<input type="hidden" name="lat" value="' + lat + '"><input type="hidden" name="lon" value="' + lon + '">');
                $('.current-location-form [type=submit]').removeClass('disabled');
                $('.current-location-form [type=submit]').prop('disabled', false);

            });
        }
    </script>
@endpush
