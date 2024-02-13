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
                    <li><a href="{{route('staff.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
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
                        
                        $timestamp = strtotime($selected_year . '-1-1 00:00:00');
                    @endphp
                    <div class="col-md-12">
                        <form action="{{ route('staff.assessment') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="eForm-label">{{get_phrase('Selected Year')}}</label>
                                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select select2">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}" @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
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
                                <tbody>
                                    @php
                                        $staff_details = App\Models\User::where('id', auth()->user()->id)->first();

                                        $incidents = App\Models\Assessment::where('user_id', $staff_details->id)
                                            ->whereDate('created_at', '>=', date('Y-1-1 00:00:00', $timestamp))
                                            ->whereDate('created_at', '<=', date('Y-12-31 23:59:59', $timestamp))
                                            ->orderBy('created_at', 'desc')
                                            ->get();
                                    @endphp
                                    @php $pre_date = ''; @endphp
                                    @foreach ($incidents as $key => $incident)
                                        @php
                                            $rowspan = App\Models\Assessment::where('user_id', $staff_details->id)
                                            ->whereDate('created_at', $incident->created_at)->count();

                                            if ($pre_date == date('d-M-Y', strtotime($incident->created_at))) {
                                                $rowspan = 0;
                                            }
                                            $pre_date = date('d-M-Y', strtotime($incident->created_at));
                                        @endphp
                                        <tr>
                                            @if ($rowspan > 0)
                                                <td class="text-13px text-dark align-baseline w-200px" rowspan="{{ $rowspan }}">
                                                    {{date('d M Y', strtotime($incident->created_at))}}
                                                </td>
                                            @endif
                                            <td class="ps-3 align-baseline p-0">
                                                {!! script_checker($incident->description) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
