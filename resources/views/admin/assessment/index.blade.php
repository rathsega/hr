@extends('index')
@push('title', get_phrase('Assessment'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Assessment') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Assessment') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

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
                        <form action="{{ route('admin.assessment') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Year</label>
                                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select select2">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}" @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Month</label>
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
                                    $selected_date = $selected_year . '-' . $selected_month . '-' . $day . ' 00:00:00';
                                    $assessment_staffs = App\Models\Assessment::join('users', 'users.id', '=', 'assessments.user_id')
                                        ->whereDate('assessments.created_at', $selected_date)
                                        ->select('assessments.user_id', DB::raw('count(*) as total_incident'))
                                        ->groupBy('assessments.user_id')
                                        ->orderBy('users.sort');
                                    if ($assessment_staffs->count() == 0) {
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
                                            {{ $day }} {{ date('M Y', $timestamp_of_first_date) }}
                                        </button>
                                    </h2>
                                    <div id="collapseaccordion{{ $day }}" class="accordion-collapse collapse @if ($counter == 1) show @endif"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">





                                            <div class="table-responsive">
                                                <table class="table eTable">
                                                    <tbody>
                                                        {{-- <thead>
                                                            <th>{{get_phrase('User')}}</th>
                                                            <th>{{get_phrase('Date')}}</th>
                                                            <th>{{get_phrase('Assessment')}}</th>
                                                            <th></th>
                                                        </thead> --}}
                                                        @foreach ($assessment_staffs->get() as $assessment_staff)
                                                            @php
                                                                $incidents = App\Models\Assessment::where('user_id', $assessment_staff->user_id)
                                                                    ->whereDate('created_at', $selected_date)
                                                                    ->get();
                                                                $staff_details = App\Models\User::where('id', $assessment_staff->user_id)->first();
                                                            @endphp
                                                            @foreach ($incidents as $key => $incident)
                                                                <tr>
                                                                    @if ($key == 0)
                                                                        <td class="text-13px text-dark text-center align-baseline w-200px" rowspan="{{ $incidents->count() }}">
                                                                            <img class="rounded-circle mt-2" src="{{ get_image('uploads/user-image/' . $staff_details->photo) }}"
                                                                                width="30px">
                                                                            <p class="p-0 m-0 text-dark">{{ $staff_details->name }}</p>
                                                                            <p class="text-13px p-0 text-center mb-2">
                                                                                <span class="badge bg-secondary">
                                                                                    {{ $staff_details->designation }}
                                                                                </span>
                                                                            </p>
                                                                        </td>
                                                                    @endif
                                                                    <td class="ps-3 align-baseline p-0">
                                                                        {{ date('d M Y', $incident->date_time) }}
                                                                    </td>
                                                                    <td class="ps-3 align-baseline p-0">
                                                                        {!! script_checker($incident->description) !!}
                                                                    </td>
                                                                    <td class="p-0 ">
                                                                        <div class="invisible-layout">
                                                                            <a href="{{ route('admin.assessment', ['id' => $incident->id]) }}" class="btn btn p-1"
                                                                                title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                    xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0"
                                                                                    viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                                                    class="">
                                                                                    <g>
                                                                                        <path
                                                                                            d="m496.063 62.299-46.396-46.4c-21.199-21.199-55.689-21.198-76.888 0L27.591 361.113c-2.17 2.17-3.624 5.054-4.142 7.875L.251 494.268a15.002 15.002 0 0 0 17.48 17.482L143 488.549c2.895-.54 5.741-2.008 7.875-4.143l345.188-345.214c21.248-21.248 21.251-55.642 0-76.893zM33.721 478.276l14.033-75.784 61.746 61.75-75.779 14.034zm106.548-25.691L59.41 371.721 354.62 76.488l80.859 80.865-295.21 295.232zM474.85 117.979l-18.159 18.161-80.859-80.865 18.159-18.161c9.501-9.502 24.96-9.503 34.463 0l46.396 46.4c9.525 9.525 9.525 24.939 0 34.465z"
                                                                                            fill="#000000" data-original="#000000" class=""></path>
                                                                                    </g>
                                                                                </svg>
                                                                            </a>

                                                                            <a href="#" onclick="confirmModal('{{ route('admin.assessment.delete', $incident->id) }}')"
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
        <div class="col-md-4">
            <div class="eSection-wrap">
                <div class="row">
                    <div class="col-md-12">
                        @if (isset($_GET['id']) && $_GET['id'] > 0)
                            @include('admin.assessment.edit')
                        @else
                            @include('admin.assessment.add')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
