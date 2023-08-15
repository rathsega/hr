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
                        <form action="{{ route('admin.timesheet') }}" method="get" id="filterForm">
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
                                    $start_timestamp = strtotime($selected_year.'-'.$selected_month.'-'.$day.' 00:00:00');
                                    $end_timestamp = strtotime($selected_year.'-'.$selected_month.'-'.$day.' 23:59:59');

                                    $timesheet_staffs = App\Models\Timesheet::join('users', 'users.id', '=', 'timesheets.user_id')->where('timesheets.from_date', '>=', $start_timestamp)->where('timesheets.to_date', '<=', $end_timestamp)->select('timesheets.user_id', DB::raw('count(*) as user_work_list'))->groupBy('timesheets.user_id')->orderBy('users.sort');
                                    if ($timesheet_staffs->count() == 0) {
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
                                            {{ date('d M - l', $start_timestamp) }}
                                        </button>
                                    </h2>
                                    <div id="collapseaccordion{{ $day }}" class="accordion-collapse collapse @if($counter == 1) show @endif"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body px-0">
                                            <div class="table-responsive">
                                                <table class="table eTable">
                                                    <tbody>
                                                        @foreach($timesheet_staffs->get() as $timesheet_staff)
                                                        @php
                                                            $staff = App\Models\User::find($timesheet_staff->user_id);
                                                            $timesheets = DB::table('timesheets')->where('user_id', $staff->id)->where('from_date', '>=', $start_timestamp)->where('to_date', '<=', $end_timestamp)->get();
                                                            @endphp

                                                            @foreach($timesheets as $key => $timesheet)
                                                                <tr>
                                                                    @if($key == 0)
                                                                        <td class="text-13px text-dark text-center" rowspan="{{$timesheets->count()}}" style="width: 130px; padding: 0px !important;">
                                                                            {{$staff->name}}
                                                                            <p class="text-13px p-0 text-center">
                                                                                <span class="badge bg-secondary" title="{{get_phrase('Working time')}}" data-bs-toggle="tooltip">
                                                                                @php
                                                                                    $total_working_time = $timesheets->sum('working_time');
                                                                                    $hr = gmdate('G', $total_working_time);
                                                                                    $min = gmdate('i', $total_working_time);
                                                                                    if($hr > 0){ echo $hr.'hr '; }
                                                                                    if($min > 0){ echo $min.'min'; }
                                                                                @endphp
                                                                                </span>
                                                                            </p>
                                                                        </td>
                                                                    @endif
                                                                    <td class="text-12px text-start" style="width: 160px; padding: 0px !important;">
                                                                        {{date('h:i a', $timesheet->from_date)}} - {{date('h:i a', $timesheet->to_date)}}
                                                                    </td>
                                                                    <td style="padding: 0px !important;">
                                                                        {{$timesheet->description}}
                                                                    </td>
                                                                    <td class="p-0" style="width: 100px; padding: 0px !important;">
                                                                        @if($timesheet->location)
                                                                            <svg id="fi_9062151" height="15" viewBox="500 50 90 900" width="10" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><g stroke="rgb(0,0,0)" stroke-miterlimit="10"><path d="m500 843.54a16 16 0 0 1 -13.83-8c-.57-1-57.51-98.94-114.89-201.5-117.18-209.47-122.07-233.92-123.67-242l-.06-.3-1.55-8.63c0-.09 0-.18 0-.28a260.4 260.4 0 0 1 -3.33-41.43 257.4 257.4 0 1 1 514.8 0 260.4 260.4 0 0 1 -3.33 41.43c0 .1 0 .19-.05.28l-1.57 8.71-.06.3c-1.6 8-6.49 32.49-123.67 242-57.45 102.52-114.39 200.48-114.96 201.46a16 16 0 0 1 -13.83 7.96zm-221-457.54c1.78 8.54 17.17 48.3 120.2 232.49 40.31 72 80.4 141.82 100.79 177.14 20.4-35.33 60.5-105.12 100.81-177.18 103.03-184.18 118.41-223.94 120.2-232.45l1.51-8.39a227.58 227.58 0 0 0 2.9-36.18c-.01-124.31-101.12-225.43-225.41-225.43s-225.4 101.12-225.4 225.4a227.58 227.58 0 0 0 2.9 36.18z"></path><path d="m500 479.77c-85 0-154.2-69.18-154.2-154.2s69.2-154.2 154.2-154.2 154.2 69.17 154.2 154.2-69.2 154.2-154.2 154.2zm0-276.4a122.2 122.2 0 1 0 122.2 122.2 122.33 122.33 0 0 0 -122.2-122.2z"></path><path d="m500 916c-114.53 0-230.47-30.39-230.47-88.46 0-16.9 10.35-41.23 59.66-61.21 33.18-13.45 78.9-22.64 128.77-25.89a16 16 0 1 1 2.04 31.93c-46.54 3-88.74 11.42-118.83 23.61-29.28 11.87-39.68 24.42-39.68 31.56 0 9.22 16.06 24 51.94 36.08 38.94 13.14 90.98 20.38 146.57 20.38s107.63-7.24 146.53-20.38c35.88-12.13 51.94-26.86 51.94-36.08 0-7.14-10.4-19.69-39.68-31.56-30.09-12.19-72.29-20.57-118.79-23.61a16 16 0 1 1 2-31.93c49.87 3.25 95.59 12.44 128.77 25.89 49.31 20 59.66 44.31 59.66 61.21.04 58.07-115.9 88.46-230.43 88.46z"></path></g></svg>
                                                                            {{$timesheet->location}}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr><td></td><td></td><td></td><td></td></tr>
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
                        <form class="current-location-form" action="{{route('admin.timesheet.store')}}" method="post">
                            @Csrf
            
            
                            <div class="row">
                                <div class="col-md-12">
                                    @if (auth()->user()->role != 'admin')
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                                    @else
                                        <div class="fpb-7">
                                            <label class="eForm-label">Select User</label>
                                            <select name="user_id"
                                                class="form-select eForm-select eChoice-multiple-without-remove" required>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        @if ($user->id == auth()->user()->id) selected @endif>
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
                                        <label for="fromDate" class="eForm-label">From</label>
                                        <input type="datetime-local" value="{{date('Y-m-d H:i')}}" name="from_date"
                                        class="form-control eForm-control"
                                        id="fromDate" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="fpb-7">
                                        <label for="toDate" class="eForm-label">To</label>
                                        <input type="datetime-local" value="{{date('Y-m-d H:i')}}"
                                        class="form-control eForm-control" name="to_date"
                                        id="toDate" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="fpb-7">
                                        <label for="eInputText" class="eForm-label">Work description</label>
                                        <textarea rows="2" class="form-control" name="description" required>{{old('description')}}</textarea>
                                        @if($errors->has('description'))
                                            <small class="text-danger">
                                                {{__($errors->first('description'))}}
                                            </small>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn-form mt-2 mb-3" disabled>Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                $('.current-location-form').prepend('<input type="hidden" name="lat" value="'+lat+'"><input type="hidden" name="lon" value="'+lat+'">');
                $('.current-location-form [type=submit]').removeClass('disabled');
                $('.current-location-form [type=submit]').prop('disabled', false);

            });
        }
    </script>
@endpush