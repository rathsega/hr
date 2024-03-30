@extends('index')
@push('title', get_phrase('Leave'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Leave') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="{{route('staff.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="#">{{ get_phrase('Leave') }}</a></li>
            </ul>
        </div>
        @php
        $carry_forwarded_leave_count = DB::table('carry_forwarded_leaves_count')->where('user_id',auth()->user()->id)->get();
        if(!$carry_forwarded_leave_count->isEmpty()){
        $carry_forwarded_leave_count = $carry_forwarded_leave_count[0]->count;
        }else{
        $carry_forwarded_leave_count = 0;
        }
        $leaves_count = App\Models\Leaves_count::get()->First();
        $sick_leaves = App\Models\Leave_application::where('user_id', auth()->user()->id)->where('leave_type','sick_leave')->whereNotIn('leave_applications.status', ['hr_rejected', 'manager_rejected'])/*->whereYear("FROM_UNIXTIME(from_date)", now()->year)->whereYear("FROM_UNIXTIME(to_date)", now()->year)*/->get();
        $casual_leaves = App\Models\Leave_application::where('user_id', auth()->user()->id)->where('leave_type','casual_leave')->whereNotIn('leave_applications.status', ['hr_rejected', 'manager_rejected'])/*->whereYear("FROM_UNIXTIME(from_date)", now()->year)->whereYear("FROM_UNIXTIME(to_date)", now()->year)*/->get();

        //check any holidays in the leave days
        $holidays_list = App\Models\Holidays::orderBy('name')->get();
        function numberOfHolidayExisted($holidays_list, $from_date, $to_date){
        $no_of_holidays = 0;
        foreach($holidays_list as $holiday){
        if ((date('Y-m-d', strtotime($holiday->date)) >= date('Y-m-d', strtotime($from_date))) && (date('Y-m-d', strtotime($holiday->date)) <= date('Y-m-d', strtotime($to_date))) && !$holiday->optional){
            $no_of_holidays += 1;
            }
            }

            return $no_of_holidays;

            }

            function countSundaysAndEvenSaturdays($startDate, $endDate) {
            $startDateTime = new DateTime($startDate);
            $endDateTime = new DateTime($endDate);

            $sundays = 0;
            $evenSaturdays = 0;

            while ($startDateTime <= $endDateTime) { $dayOfWeek=$startDateTime->format('w'); // 0 (Sunday) to 6 (Saturday)

                if ($dayOfWeek == 0) { // Sunday
                $sundays++;
                } elseif ($dayOfWeek == 6) { // Even Saturday
                $dayOfMonth = $startDateTime->format('d');
                $weekNum = ceil($dayOfMonth / 7);
                if ($weekNum % 2 == 0) { //check that the week number is even
                $evenSaturdays += 1;
                }

                }

                $startDateTime->modify('+1 day');
                }

                return ['sundays' => $sundays, 'evenSaturdays' => $evenSaturdays];
                }

                function getHalfdayHourLimitForLeave($date_time_stamp){
                if(date('N', $date_time_stamp) == 6){
                return 3;
                }else{
                return 4.5;
                }
                }

                //Calculate Sick Leave Count
                $sick_leave_count = 0;
                if(!$sick_leaves->isEmpty()){
                foreach ($sick_leaves as $sick_leave){
                $from_year = date('Y', $sick_leave->from_date);
                $from_date = date('Y-m-d', $sick_leave->from_date);
                $to_year = date('Y', $sick_leave->to_date);
                $to_date = date('Y-m-d', $sick_leave->to_date);
                $current_year = date('Y');
                if($from_year == $current_year || $to_year == $current_year){
                if($from_year == $current_year && $to_year == $current_year ){
                $datediff = $sick_leave->to_date - $sick_leave->from_date;
                if(date("Y-m-d", $sick_leave->from_date) == date("Y-m-d", $sick_leave->to_date)){
                $hours = $datediff/3600;
                if($hours > getHalfdayHourLimitForLeave($sick_leave->from_date)){
                $sick_leave_count += 1;
                }else{
                $sick_leave_count += 0.5;
                }
                }else{
                $sick_leave_count += (round($datediff / (60 * 60 * 24)))+1;
                $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date, $to_date);
                $saturday_sunday = countSundaysAndEvenSaturdays($from_date, $to_date);
                $sick_leave_count = $sick_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                }
                }else if($from_year == $current_year && $to_year == $current_year+1){
                $your_date = strtotime($from_date);
                $datediff = strtotime($current_year."-12-31") - $your_date;
                $sick_leave_count += (round($datediff / (60 * 60 * 24)))+1;
                $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date,date(strtotime($current_year."-12-31")));
                $saturday_sunday = countSundaysAndEvenSaturdays($from_date, date('Y-m-d',strtotime($current_year."-12-31")));
                $sick_leave_count = $sick_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                }else if($from_year == $current_year-1 && $to_year == $current_year){
                $your_date = strtotime($to_date);
                $datediff = $your_date - strtotime($current_year."-01-01");
                $sick_leave_count += (round($datediff / (60 * 60 * 24)))+1;
                $no_of_holidays = numberOfHolidayExisted($holidays_list, date(strtotime($current_year."-01-01")), $to_date);
                $saturday_sunday = countSundaysAndEvenSaturdays(date('Y-m-d',strtotime($current_year."-01-01")), $to_date);
                $sick_leave_count = $sick_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                }
                }

                }
                }

                //Calculate Casual Leave Count
                $casual_leave_count = 0;
                if(!$casual_leaves->isEmpty()){
                foreach ($casual_leaves as $casual_leave){
                //var_dump($casual_leave);
                $from_year = date('Y', $casual_leave->from_date);
                $from_date = date('Y-m-d', $casual_leave->from_date);
                $to_year = date('Y', $casual_leave->to_date);
                $to_date = date('Y-m-d', $casual_leave->to_date);
                $current_year = date('Y');
                if($from_year == $current_year || $to_year == $current_year){
                //echo $casual_leave->to_date . "===" . $casual_leave->from_date;
                if($from_year == $current_year && $to_year == $current_year ){
                $datediff = $casual_leave->to_date - $casual_leave->from_date;
                if(date("Y-m-d", $casual_leave->from_date) == date("Y-m-d", $casual_leave->to_date)){
                $hours = $datediff/3600;
                if($hours > getHalfdayHourLimitForLeave($casual_leave->from_date)){
                $casual_leave_count += 1;
                }else{
                $casual_leave_count += 0.5;
                }
                }else{
                $casual_leave_count += (round($datediff / (60 * 60 * 24)))+1;
                $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date, $to_date);
                $saturday_sunday = countSundaysAndEvenSaturdays($from_date, $to_date);
                $casual_leave_count = $casual_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                }
                }else if($from_year == $current_year && $to_year == $current_year+1){
                $your_date = strtotime($from_date);
                $datediff = strtotime($current_year."-12-31") - $your_date;
                $casual_leave_count += (round($datediff / (60 * 60 * 24)))+1;
                $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date,date(strtotime($current_year."-12-31")));
                $saturday_sunday = countSundaysAndEvenSaturdays($from_date, date('Y-m-d',strtotime($current_year."-12-31")));
                $casual_leave_count = $casual_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                }else if($from_year == $current_year-1 && $to_year == $current_year){
                $your_date = strtotime($to_date);
                $datediff = $your_date - strtotime($current_year."-01-01");
                $casual_leave_count += (round($datediff / (60 * 60 * 24)))+1;
                $no_of_holidays = numberOfHolidayExisted($holidays_list, date(strtotime($current_year."-01-01")), $to_date);
                $saturday_sunday = countSundaysAndEvenSaturdays(date('Y-m-d',strtotime($current_year."-01-01")), $to_date);
                $casual_leave_count = $casual_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                }
                }

                }
                }
                @endphp
                <div class="export-btn-area d-flex ">
                    <a href="#" class="export_btn">
                        @php 
                            $available_cfl_count = $carry_forwarded_leave_count >= $casual_leave_count ? $carry_forwarded_leave_count - $casual_leave_count : 0; 
                        @endphp
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Carry Forwarded Leaves') }} : <span class="badge bg-secondary ms-auto me-3" data-bs-toggle="tooltip">{{ $carry_forwarded_leave_count >= $casual_leave_count ? $carry_forwarded_leave_count - $casual_leave_count : 0 }}</span></span>
                    </a>
                    <a href="#" class="export_btn  ms-1">
                        @php $available_sick_leave_count = $leaves_count->sick = (($leaves_count->sick/12)*date("m")) @endphp
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Sick Leaves') }} : <span class="badge bg-secondary ms-auto me-3" data-bs-toggle="tooltip">{{$leaves_count->sick - $sick_leave_count}}</span></span>
                    </a>
                    <a href="#" class="export_btn  ms-1">
                        @php $leaves_count->casual = (($leaves_count->casual/12)*date("m")); @endphp
                        @php $available_casual_leave_count = $carry_forwarded_leave_count < $casual_leave_count ? $leaves_count->casual + $carry_forwarded_leave_count - $casual_leave_count : $leaves_count->casual @endphp
                            <span class="d-none d-sm-inline-block">{{ get_phrase('Casual Leaves') }} : <span class="badge bg-secondary ms-auto me-3" data-bs-toggle="tooltip">{{$carry_forwarded_leave_count < $casual_leave_count ? $leaves_count->casual + $carry_forwarded_leave_count - $casual_leave_count : $leaves_count->casual }}</span></span>
                    </a>
                </div>
    </div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column eForm-label " style="margin-top: 20px;">
                <i>Note : Your leave balance will be updated monthly with half a day of sick leave and one casual leave </i>
            </div>
        </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="eSection-wrap">
            <p class="column-title mb-2">{{get_phrase('Leave Reports')}}</p>
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

                $timestamp = strtotime($selected_year . '-' . $selected_month . '-1 00:00:00');
                @endphp
                <div class="col-md-12">
                    <form action="{{ route('staff.leave.report') }}" method="get" id="filterForm">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="eForm-label">{{get_phrase('Selected Year')}}</label>
                                <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select select2">
                                    @for ($year = date('Y'); $year >= 2022; $year--)
                                    @php
                                    $pending_request = App\Models\Leave_application::where('leave_applications.status', 'pending')
                                    ->where('user_id', auth()->user()->id)
                                    ->where('from_date', '>=', strtotime($year . '-1-1 00:00:00'))
                                    ->where('from_date', '<=', strtotime($year . '-12-31 23:59:59' )); $pending_req_counted=$pending_request->count();
                                        @endphp
                                        <option value="{{ $year }}" @if ($selected_year==$year) selected @endif>
                                            {{ $year }} @if ($pending_req_counted > 0)
                                            <small>({{ $pending_req_counted . ' ' . get_phrase('Pending request') }})</small>
                                            @endif
                                        </option>
                                        @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="eForm-label">{{get_phrase('Selected Month')}}</label>
                                <select onchange="$('#filterForm').submit();" name="month" class="form-select eForm-select select2">
                                    @for ($month = 1; $month <= 12; $month++) @php $timestamp_month_wise=strtotime($selected_year . '-' . $month . '-1 00:00:00' ); $pending_request=App\Models\Leave_application::where('leave_applications.status', 'pending' ) ->where('user_id', auth()->user()->id)
                                        ->where('from_date', '>=', strtotime($selected_year . '-' . $month . '-1 00:00:00'))
                                        ->where('from_date', '<=', strtotime(date('Y-m-t 00:00:00', $timestamp_month_wise))); $pending_req_counted=$pending_request->count();
                                            @endphp
                                            <option value="{{ $month }}" @if ($selected_month==$month) selected @endif>
                                                {{ date('F', strtotime($year . '-' . $month . '-20')) }}
                                                @if ($pending_req_counted > 0)
                                                <small>({{ $pending_req_counted . ' ' . get_phrase('Pending request') }})</small>
                                                @endif
                                            </option>
                                            @endfor
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12 pb-4">
                    <div class="table-responsive">
                        <table class="table eTable">
                            <thead>
                                <tr>
                                    <th class="text-center">{{get_phrase('Type')}}</th>
                                    <th class="text-center">{{get_phrase('Date')}}</th>
                                    <th>{{get_phrase('Reason')}}</th>
                                    <th class="text-center">{{get_phrase('Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $leave_reports = App\Models\Leave_application::where('user_id', auth()->user()->id)
                                ->where('from_date', '>=', $timestamp)
                                ->where('from_date', '<=', strtotime(date('Y-m-t 23:59:59', $timestamp))) ->orderBy('id', 'desc');
                                    @endphp
                                    @if(!$leave_reports->get()->isEmpty())
                                    @foreach ($leave_reports->get() as $leave_report)
                                    <tr>
                                        <td>
                                            @if ($leave_report->leave_type == 'sick_leave')
                                            <span class="badge bg-danger">{{get_phrase('Sick Leave')}}</span>
                                            @elseif($leave_report->leave_type == 'casual_leave')
                                            <span class="badge bg-secondary">{{get_phrase('Casual Leave')}}</span>
                                            @elseif($leave_report->leave_type == 'meternity_leave')
                                            <span class="badge bg-secondary">{{get_phrase('Maternity Leave')}}</span>
                                            @elseif($leave_report->leave_type == 'paternity_leave')
                                            <span class="badge bg-secondary">{{get_phrase('Paternity Leave')}}</span>
                                            @elseif($leave_report->leave_type == 'loss_of_pay')
                                            <span class="badge bg-success">{{get_phrase('Loss Of Pay')}}</span>
                                            @elseif($leave_report->leave_type == 'work_from_home')
                                            <span class="badge bg-success">{{get_phrase('Work From Home')}}</span>
                                            @endif
                                        </td>

                                        <td class="text-center w-255px">
                                            @if (date('d M Y', $leave_report->from_date) == date('d M Y', $leave_report->to_date))
                                            {{ date('d M Y', $leave_report->from_date) }}
                                            <hr class="my-0">
                                            {{ date('h:i A', $leave_report->from_date) }} - {{ date('h:i A', $leave_report->to_date) }}
                                            @else
                                            {{ date('d M Y, h:i A', $leave_report->from_date) }}
                                            <hr class="my-0">
                                            {{ date('d M Y, h:i A', $leave_report->to_date) }}
                                            @endif
                                        </td>
                                        <td>
                                            @php echo script_checker($leave_report->reason); @endphp

                                            @if ($leave_report->attachment)
                                            <a href="{{ asset($leave_report->attachment) }}" download>
                                                <br>
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                    <g>
                                                        <path d="M128 65c0 15.439-12.563 28-28 28H80c-2.211 0-4-1.791-4-4s1.789-4 4-4h20c11.027 0 20-8.973 20-20s-8.973-20-20-20h-4c-2.211 0-4-1.791-4-4 0-15.439-12.563-28-28-28S36 25.561 36 41c0 2.209-1.789 4-4 4h-4C16.973 45 8 53.973 8 65s8.973 20 20 20h20c2.211 0 4 1.791 4 4s-1.789 4-4 4H28C12.563 93 0 80.439 0 65s12.563-28 28-28h.223C30.219 19.025 45.5 5 64 5s33.781 14.025 35.777 32H100c15.438 0 28 12.561 28 28zm-50.828 37.172L68 111.344V61c0-2.209-1.789-4-4-4s-4 1.791-4 4v50.344l-9.172-9.172c-1.563-1.563-4.094-1.563-5.656 0s-1.563 4.094 0 5.656l16 16c.781.781 1.805 1.172 2.828 1.172s2.047-.391 2.828-1.172l16-16c1.563-1.563 1.563-4.094 0-5.656s-4.094-1.563-5.656 0z" fill="#000000" data-original="#000000" class=""></path>
                                                    </g>
                                                </svg>
                                                {{ get_phrase('Download') }}
                                            </a>
                                            @endif
                                        </td>
                                        <td class="text-center position-relative w-80px">
                                            @if ($leave_report->status == 'pending')
                                            <span class="badge bg-danger">{{get_phrase('Pending')}}</span>
                                            @elseif($leave_report->status == 'manager_rejected')
                                            <span class="badge bg-secondary">{{get_phrase('Manager Rejected')}}</span>
                                            @elseif($leave_report->status == 'hr_rejected')
                                            <span class="badge bg-secondary">{{get_phrase('HR Rejected')}}</span>
                                            @elseif($leave_report->status == 'manager_approved')
                                            <span class="badge bg-secondary">{{get_phrase('Manager Approved')}}</span>
                                            @elseif($leave_report->status == 'hr_approved')
                                            <span class="badge bg-success">{{get_phrase('HR Approved')}}</span>
                                            @endif

                                            @if ($leave_report->status == 'pending')
                                            <div class="contant-overlay">
                                                <a href="#" onclick="confirmModal('{{ route('staff.leave.report.delete', $leave_report->id) }}')" class="btn btn p-0" title="{{ get_phrase('Delete') }}" data-bs-placement="right" data-bs-toggle="tooltip">
                                                    <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="15" height="15" viewBox="0 0 24 24">
                                                        <path d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
                                                        </path>
                                                        <path d="M20,4H16V2a1,1,0,0,0-1-1H9A1,1,0,0,0,8,2V4H4A1,1,0,0,0,4,6H20a1,1,0,0,0,0-2ZM10,4V3h4V4Z">
                                                        </path>
                                                        <path d="M11,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                        <path d="M15,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="eSection-wrap">
            <div class="row">
                <div class="col-md-12">


                    <form action="{{ route('staff.leave.report.store') }}" method="post" enctype="multipart/form-data">
                        @Csrf

                        <div class="row">
                            <div class="col-md-12">
                                @if (auth()->user()->role == 'admin')
                                <div class="fpb-7">
                                    <label class="eForm-label">{{get_phrase('Select User')}}</label>
                                    <select name="user_id" class="form-select eForm-select select2" required>
                                        <option value="">{{ get_phrase('Select a user') }}</option>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if ($user->id == auth()->user()->id) selected @endif>
                                            {{ $user->name }}
                                            @if ($user->id == auth()->user()->id)
                                            <small>({{get_phrase('Me')}})</small>
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="fpb-7">
                                    <label class="eForm-label">{{get_phrase('Leave type')}}</label>
                                    <select name="leave_type" id="leave_type" onchange="resetFormLeave()" class="form-select eForm-select select2" required>
                                        <option value="">{{ get_phrase('Select a type') }}</option>
                                        <option value="casual_leave" {{$available_casual_leave_count <= 0 ? 'disabled' : ''}}>{{ get_phrase('Casual Leave') }}</option>
                                        <option value="sick_leave" {{$available_sick_leave_count <= 0 ? 'disabled' : ''}}>{{ get_phrase('Sick Leave') }}</option>
                                        <option value="meternity_leave">{{ get_phrase('Maternity Leave') }}</option>
                                        <option value="paternity_leave">{{ get_phrase('Paternity Leave') }}</option>
                                        <option value="loss_of_pay">{{ get_phrase('Loss Of Pay') }}</option>
                                        <option value="work_from_home">{{ get_phrase('Work From Home') }}</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fpb-7">
                                    <label for="eInputTextarea" class="eForm-label">{{get_phrase('From')}}</label>
                                    <input type="datetime-local" onchange="resetFormLeave()" name="from_date" value="{{ date('Y-m-d H:i') }}" class="form-control eForm-control" id="eInputFromDateTime" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fpb-7">
                                    <label for="eInputTextarea" class="eForm-label">{{get_phrase('To')}}</label>
                                    <input type="datetime-local" onchange="resetFormLeave()" name="to_date" value="{{ date('Y-m-d H:i') }}" class="form-control eForm-control" id="eInputToDateTime" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="fpb-7">
                                    <label for="eInputTextarea" class="eForm-label">{{get_phrase('Reason')}}</label>
                                    <textarea class="form-control" rows="2" name="reason" required>{{ old('reason') }}</textarea>
                                    @if ($errors->has('reason'))
                                    <small class="text-danger">
                                        {{ $errors->first('reason') }}
                                    </small>
                                    @endif
                                </div>
                                <div class="fpb-7">
                                    <label for="photo" class="eForm-label">{{ get_phrase('Attachment') }} <small>({{get_phrase('Optional')}} - {{get_phrase('image')}}, {{get_phrase('pdf')}})</small></label>
                                    <input type="file" name="attachment" class="form-control eForm-control-file mb-0" id="photo">
                                </div>
                                <button type="submit" id="leave_request_submit_button" class="btn-form mt-2 mb-3">{{ get_phrase('Submit request') }}</button>
                                <div class="fpb-7">
                                    <label id="warning_note" class="eForm-label" style="color: red;"></label>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>

    function getHalfdayHourLimitForLeave(date_time_stamp) {
        if (new Date(date_time_stamp).getDay() === 6) {
            return 3;
        } else {
            return 4.5;
        }
    }

    function countSundaysAndEvenSaturdays(startDate, endDate) {
        var startDateTime = new Date(startDate);
        var endDateTime = new Date(endDate);
        var sundays = 0;
        var evenSaturdays = 0;
        while (startDateTime <= endDateTime) {
            var dayOfWeek = startDateTime.getDay(); // 0 (Sunday) to 6 (Saturday)
            if (dayOfWeek === 0) { // Sunday
                sundays++;
            } else if (dayOfWeek === 6) { // Even Saturday
                var dayOfMonth = startDateTime.getDate();
                var weekNum = Math.ceil(dayOfMonth / 7);
                if (weekNum % 2 === 0) { // check that the week number is even
                    evenSaturdays += 1;
                }
            }
            startDateTime.setDate(startDateTime.getDate() + 1);
        }
        // return { sundays: sundays, evenSaturdays: evenSaturdays };
        return { sundays: 0, evenSaturdays: 0 };
    }



    function resetFormLeave() {
        let leave_type = $('#leave_type').val();
        let leave_from_date = new Date($('#eInputFromDateTime').val());
        let leave_to_date = new Date($('#eInputToDateTime').val());
        if(!leave_type || !leave_from_date || !leave_to_date){
            document.getElementById("leave_request_submit_button").disabled = false;
            return true;
        }

        let from_year = new Date(leave_from_date).getFullYear();
        let from_date = new Date(leave_from_date).toISOString().split('T')[0];
        let to_year = new Date(leave_to_date).getFullYear();
        let to_date = new Date(leave_to_date).toISOString().split('T')[0];
        let current_year = new Date().getFullYear();
        let taking_leave_count = 0;
        if (from_year == current_year || to_year == current_year) {
            if (from_year == current_year && to_year == current_year) {
                let datediff = (leave_to_date - leave_from_date) / 1000;
                if (new Date(leave_from_date).toISOString().split('T')[0] == new Date(leave_to_date).toISOString().split('T')[0]) {
                    let hours = datediff / 3600;
                    if (hours > getHalfdayHourLimitForLeave(leave_from_date)) {
                        taking_leave_count += 1;
                    } else {
                        taking_leave_count += 0.5;
                    }
                } else {
                    taking_leave_count += Math.round(datediff / (60 * 60 * 24)) + 1;
                    let no_of_holidays = 0;
                    let saturday_sunday = countSundaysAndEvenSaturdays(from_date, to_date);
                    taking_leave_count = taking_leave_count - no_of_holidays - saturday_sunday.sundays - saturday_sunday.evenSaturdays;
                }
            } else if (from_year == current_year && to_year == current_year + 1) {
                let your_date = new Date(from_date);
                let datediff = new Date(current_year + "-12-31").getTime() - your_date.getTime();
                taking_leave_count += Math.round(datediff / (60 * 60 * 24)) + 1;
                let no_of_holidays = 0;
                let saturday_sunday = countSundaysAndEvenSaturdays(from_date, new Date(current_year + "-12-31").toISOString().split('T')[0]);
                taking_leave_count = taking_leave_count - no_of_holidays - saturday_sunday.sundays - saturday_sunday.evenSaturdays;
            } else if (from_year == current_year - 1 && to_year == current_year) {
                let your_date = new Date(to_date);
                let datediff = your_date.getTime() - new Date(current_year + "-01-01").getTime();
                taking_leave_count += Math.round(datediff / (60 * 60 * 24)) + 1;
                let no_of_holidays = 0;
                let saturday_sunday = countSundaysAndEvenSaturdays(new Date(current_year + "-01-01").toISOString().split('T')[0], to_date);
                taking_leave_count = taking_leave_count - no_of_holidays - saturday_sunday.sundays - saturday_sunday.evenSaturdays;
            }
        }

        let leave_req_sub_but = document.getElementById("leave_request_submit_button");
        let warning_note = document.getElementById("warning_note");
        if(leave_type == 'sick_leave' && taking_leave_count > parseFloat(<?php echo (float)$available_sick_leave_count; ?>)){
            leave_req_sub_but.disabled = true;
            warning_note.innerHTML = "You don't have Sick leaves, please choose leave type as loss of pay."
        }else if(leave_type == 'casual_leave' && taking_leave_count > parseFloat(<?php echo (float)$available_casual_leave_count + (float)$available_cfl_count; ?>)){
            leave_req_sub_but.disabled = true;
            warning_note.innerHTML = "You don't have Casual leaves, please choose leave type as loss of pay."
        }else{
            let button_disabled = leave_req_sub_but.hasAttribute('disabled');
            button_disabled ? leave_req_sub_but.removeAttribute('disabled') : '';
            warning_note.innerHTML = ""
        }
    }
</script>