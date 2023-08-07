@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-12">
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
                    @endphp
                    <div class="col-md-12">
                        <form action="{{ route('admin.assessment.daily.report') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Year</label>
                                    <select onchange="$('#filterForm').submit();" name="year"
                                        class="form-select eForm-select eChoice-multiple-without-remove">
                                        @for ($year = 2020; $year <= date('Y'); $year++)
                                            <option value="{{ $year }}"
                                                @if (isset($_GET['year']) && $_GET['year'] == $year) selected @endif>
                                                {{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Month</label>
                                    <select onchange="$('#filterForm').submit();" name="month"
                                        class="form-select eForm-select eChoice-multiple-without-remove">
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ $month }}"
                                                @if (isset($_GET['month']) && $_GET['month'] == $month) selected @endif>
                                                {{ date('F', strtotime($year . '-' . $month . '-20')) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                    </div>

                    <div class="col-md-12">
                        <div class="accordion custom-accordion" id="accordionExample">
                            @for ($day = 1; $day <= date('t', $timestamp_of_first_date); $day++)
                                @php
                                    $staffs = App\Models\User::where('status', 'active')
                                        ->orderBy('sort')
                                        ->get();
                                    
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseaccordion{{ $day }}" aria-expanded="false"
                                            aria-controls="collapseaccordion{{ $day }}">
                                            {{ $day }} {{ date('M Y', $timestamp_of_first_date) }}
                                        </button>
                                    </h2>
                                    <div id="collapseaccordion{{ $day }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table eTable">
                                                <thead>
                                                    <th>Employee</th>
                                                    <th>Event</th>
                                                    <th>Action</th>
                                                </thead>
                                                @foreach ($staffs as $staff)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ get_image('uploads/user-image/' . $staff->photo) }}"
                                                                class="rounded-circle" alt="" style="height: 50px;">
                                                            {{ $staff->name }}
                                                        </td>
                                                        <td class="fw-bold text-danger">
                                                            @php
																$incidents = App\Models\Assessment::where('user_id', $staff->id)->whereDate('created_at', '=', $selected_year . '-' . $selected_month . '-' . $day . ' 00:00:00')->get();
															@endphp
															<ul>
																@foreach($incidents as $incident)
																	<li>{{$incident->description}}</li>
																@endforeach
															</ul>
                                                        </td>
														<td>
															<a href="#" class="btn btn-primary" onclick="showRightModal('{{route('right_modal', ['view_path' => 'admin.assessment.add_daily_report', 'user_id' => $staff->id])}}')">Add Report</a>
														</td>
                                                    </tr>
                                                @endforeach
                                            </table>
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
