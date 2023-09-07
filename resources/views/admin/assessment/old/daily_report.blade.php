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
                            @for ($day = 1; $day <= date('t', $timestamp_of_first_date); $day++)
                                @php
                                    $selected_date = $selected_year . '-' . $selected_month . '-' . $day . ' 00:00:00';
                                    $incident = App\Models\Assessment::whereDate('created_at', $selected_date);
                                    if ($incident->count() == 0) {
                                        continue;
                                    }else{
                                        $incident = $incident->first();
                                    }
                                    $staff = App\Models\User::where('id', $incident->user_id)->first();
                                    
                                @endphp
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseaccordion{{ $day }}" aria-expanded="false"
                                            aria-controls="collapseaccordion{{ $day }}">
                                            {{ $day }} {{ date('M Y', $timestamp_of_first_date) }}
                                        </button>
                                    </h2>
                                    <div id="collapseaccordion{{ $day }}" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table eTable">
                                                <thead>
                                                    <th>Employee</th>
                                                    <th>Event</th>
                                                </thead>

                                                <tr>
                                                    <td>
                                                        <img src="{{ get_image('uploads/user-image/' . $staff->photo) }}"
                                                            class="rounded-circle" alt="" style="height: 50px;">
                                                        {{ $staff->name }}
                                                    </td>
                                                    <td class="fw-bold text-danger">
                                                        <ul>
                                                            @foreach (App\Models\Assessment::whereDate('created_at', $selected_date)->where('user_id', $incident->user_id)->get() as $key => $row)
                                                                <li>{{ ++$key }}. {{ $row->description }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
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
        <div class="col-md-4">
            <div class="eSection-wrap">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('admin.assessment.incident.store') }}" method="POST">
                            @Csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="fpb-7">
                                        <label for="staffId" class="eForm-label">Select an employee</label>
                                        <select name="user_id"
                                            class="form-select eForm-select eChoice-multiple-without-remove" id="staffId"
                                            required>
                                            @foreach (App\Models\User::where('status', 'active')->where('role', 'staff')->orderBy('sort')->get() as $staff)
                                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="fpb-7">
                                        <label for="eInputText" class="eForm-label">Description of incident</label>
                                        <textarea rows="2" class="form-control" name="description" required>{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <small class="text-danger">
                                                {{ __($errors->first('description')) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="fpb-7">
                                        <label for="toDate" class="eForm-label">Date</label>
                                        <input type="datetime-local" value="{{ date('Y-m-d H:i') }}"
                                            class="form-control eForm-control" name="date_time" id="toDate" />
                                    </div>
                                    <button type="submit" class="btn-form mt-2 mb-3">Add incident</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
