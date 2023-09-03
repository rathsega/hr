@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="eSection-wrap">
                <p class="column-title mb-2">Leave Reports</p>
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
                        <form action="{{ route('admin.leave.report') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Year</label>
                                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select eChoice-multiple-without-remove">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}" @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Month</label>
                                    <select onchange="$('#filterForm').submit();" name="month" class="form-select eForm-select eChoice-multiple-without-remove">
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
                                    
                                    $staff_leave_reports = App\Models\Leave_application::join('users', 'users.id', '=', 'leave_applications.user_id')
                                        ->where('from_date', '>=', $start_timestamp)
                                        ->where('from_date', '<=', $end_timestamp)
                                        ->select('leave_applications.user_id', DB::raw('count(*) as user_total_leave'))
                                        ->groupBy('leave_applications.user_id')
                                        ->orderBy('users.sort');
                                    if ($staff_leave_reports->count() == 0) {
                                        continue;
                                    } else {
                                        $counter += 1;
                                    }

                                    $pending_request = App\Models\Leave_application::where('from_date', '>=', $start_timestamp)->where('from_date', '<=', $end_timestamp)->where('leave_applications.status', 'pending');
                                    $approved_request = App\Models\Leave_application::where('from_date', '>=', $start_timestamp)->where('from_date', '<=', $end_timestamp)->where('leave_applications.status', 'approved');
                                    
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button @if ($counter > 1) collapsed @endif" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseaccordion{{ $day }}" aria-expanded="@if ($counter == 1) true @else false @endif"
                                            aria-controls="collapseaccordion{{ $day }}">
                                            
                                            @if ($pending_request->count() > 0)
                                                <span class="badge bg-danger me-3" title="{{ get_phrase('Pending request') }}" data-bs-toggle="tooltip">
                                                    {{ $pending_request->count() }}
                                                </span>
                                            @endif
                                            @if ($approved_request->count() > 0)
                                                <span class="badge bg-success me-3" title="{{ get_phrase('Approved request') }}" data-bs-toggle="tooltip">
                                                    {{ $approved_request->count() }}
                                                </span>
                                            @endif
                                            {{ date('d M - l', $start_timestamp) }}
                                        </button>
                                    </h2>
                                    <div id="collapseaccordion{{ $day }}" class="accordion-collapse collapse @if ($counter == 1) show @endif"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="table-responsive">
                                                <table class="table eTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Employee</th>
                                                            <th class="text-center">Date</th>
                                                            <th>Reason</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($staff_leave_reports->get() as $staff_leave_report)
                                                            @php
                                                                $staff_details = App\Models\User::where('id', $staff_leave_report->user_id);
                                                                if ($staff_details->count() == 0) {
                                                                    continue;
                                                                }
                                                                $staff_details = $staff_details->first();
                                                                $leave_reports = App\Models\Leave_application::where('user_id', $staff_details->id)
                                                                    ->where('from_date', '>=', $start_timestamp)
                                                                    ->where('from_date', '<=', $end_timestamp)
                                                                    ->orderBy('id', 'desc');
                                                            @endphp
                                                            @foreach ($leave_reports->get() as $leave_report)
                                                                <tr>
                                                                    <td class="text-center" style="width: 170px;">
                                                                        <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $staff_details->photo) }}"
                                                                            width="30px">
                                                                        <p class="text-dark">{{ $staff_details->name }}</p>
                                                                        @if ($leave_report->status == 'pending')
                                                                            <span class="badge bg-danger">Pending</span>
                                                                        @elseif($leave_report->status == 'rejected')
                                                                            <span class="badge bg-secondary">Rejected</span>
                                                                        @else
                                                                            <span class="badge bg-success">Approved</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center" style="width: 255px;">
                                                                        {{ date('d M Y, h:i A', $leave_report->from_date) }}
                                                                        <p class="text-12px text-dark p-0 m-0 fw-bold">To</p>
                                                                        {{ date('d M Y, h:i A', $leave_report->to_date) }}
                                                                    </td>
                                                                    <td style="">
                                                                        @php echo script_checker($leave_report->reason); @endphp
                                                                    </td>
                                                                    <td class="text-center" style="width: 80px;">
                                                                        @if ($leave_report->status != 'approved')
                                                                            <a href="#"
                                                                                onclick="confirmModal('{{ route('admin.leave.report.status', ['id' => $leave_report->id, 'status' => 'approved']) }}')"
                                                                                class="btn btn p-0 px-1" title="{{ get_phrase('Approve') }}" data-bs-toggle="tooltip">
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

                                                                        @if ($leave_report->status != 'rejected')
                                                                            <a href="#"
                                                                                onclick="confirmModal('{{ route('admin.leave.report.status', ['id' => $leave_report->id, 'status' => 'rejected']) }}')"
                                                                                class="btn btn p-0 px-1" title="{{ get_phrase('Reject') }}" data-bs-toggle="tooltip">
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

                                                                        <a href="#" onclick="confirmModal('{{ route('admin.leave.report.delete', $leave_report->id) }}')"
                                                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="15" height="15"
                                                                                viewBox="0 0 24 24">
                                                                                <path
                                                                                    d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
                                                                                </path>
                                                                                <path d="M20,4H16V2a1,1,0,0,0-1-1H9A1,1,0,0,0,8,2V4H4A1,1,0,0,0,4,6H20a1,1,0,0,0,0-2ZM10,4V3h4V4Z">
                                                                                </path>
                                                                                <path d="M11,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                                                <path d="M15,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                                            </svg>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
        <div class="col-md-4">
            <div class="eSection-wrap">
                <div class="row">
                    <div class="col-md-12">


                        <form action="{{ route('admin.leave.report.store') }}" method="post">
                            @Csrf

                            <div class="row">
                                <div class="col-md-12">
                                    @if (auth()->user()->role == 'admin')
                                        <div class="fpb-7">
                                            <label class="eForm-label">Select User</label>
                                            <select name="user_id" class="form-select eForm-select eChoice-multiple-without-remove" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" @if ($user->id == auth()->user()->id) selected @endif>
                                                        {{ $user->name }}
                                                        @if ($user->id == auth()->user()->id)
                                                            <small>(Me)</small>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="fpb-7">
                                        <label for="eInputTextarea" class="eForm-label">From</label>
                                        <input type="datetime-local" name="from_date" value="{{ date('Y-m-d H:i') }}" class="form-control eForm-control" id="eInputDateTime" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fpb-7">
                                        <label for="eInputTextarea" class="eForm-label">To</label>
                                        <input type="datetime-local" name="to_date" value="{{ date('Y-m-d H:i') }}" class="form-control eForm-control" id="eInputDateTime" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fpb-7">
                                        <label for="eInputTextarea" class="eForm-label">Reason</label>
                                        <textarea class="form-control" rows="2" name="reason" required>{{ old('reason') }}</textarea>
                                        @if ($errors->has('reason'))
                                            <small class="text-danger">
                                                {{ $errors->first('reason') }}
                                            </small>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn-form mt-2 mb-3">Submit request</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
