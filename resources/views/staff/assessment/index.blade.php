@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-8">
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
                        <form action="{{ route('staff.assessment') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Year</label>
                                    <select onchange="$('#filterForm').submit();" name="year"
                                        class="form-select eForm-select eChoice-multiple-without-remove">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}"
                                                @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Month</label>
                                    <select onchange="$('#filterForm').submit();" name="month"
                                        class="form-select eForm-select eChoice-multiple-without-remove">
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ $month }}"
                                                @if ($selected_month == $month) selected @endif>
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
                            @for ($day = $total_days_of_this_month; $day >= 1;  $day--)
                                @php
                                    $selected_date = $selected_year . '-' . $selected_month . '-' . $day . ' 00:00:00';
                                    $assessment_staffs = App\Models\Assessment::join('users', 'users.id', '=', 'assessments.user_id')->where('users.id', auth()->user()->id)->whereDate('assessments.created_at', $selected_date)->select('assessments.user_id', DB::raw('count(*) as total_incident'))->groupBy('assessments.user_id')->orderBy('users.sort');
                                    if ($assessment_staffs->count() == 0) {
                                        continue;
                                    }else{
                                        $counter += 1;
                                    }
                                    
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button @if($counter > 1) collapsed @endif" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseaccordion{{ $day }}" aria-expanded="@if($counter == 1) true @else false @endif"
                                            aria-controls="collapseaccordion{{ $day }}">
                                            {{ $day }} {{ date('M Y', $timestamp_of_first_date) }}
                                        </button>
                                    </h2>
                                    <div id="collapseaccordion{{ $day }}" class="accordion-collapse collapse @if($counter == 1) show @endif"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @foreach($assessment_staffs->get() as $key => $assessment_staff)
                                                @php
                                                    $incidents = App\Models\Assessment::where('user_id', $assessment_staff->user_id)->whereDate('created_at', $selected_date)->get();
                                                    $staff_details = App\Models\User::where('id', $assessment_staff->user_id)->first();
                                                @endphp
                                                <div class="row @if($key > 0) border-top @endif mb-2 pt-2">
                                                    <div class="col-md-6 text-13px text-dark">
                                                        <img src="{{ get_image('uploads/user-image/' . $staff_details->photo) }}"
                                                                class="rounded-circle" alt="" style="height: 50px;">
                                                            {{ $staff_details->name }}
                                                    </div>
                                                    <div class="col-md-6 text-13px text-dark">
                                                        <ul>
                                                            @foreach ($incidents as $key => $incident)
                                                                <li>{{ ++$key }}. {{ $incident->description }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
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
                Rating here
            </div>
        </div>
    </div>
@endsection
