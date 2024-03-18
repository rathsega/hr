==@extends('index')
@push('title', get_phrase('Payroll Configuration'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Payroll Configuration') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('manager.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Payroll Configuration') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <form action="{{ route('manager.payrollconfiguration.generate') }}" method="post" id="filterForm">
        @csrf
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="eForm-label">{{get_phrase('Selected Year')}}</label>
                    <select name="year" class="form-select eForm-select select2">
                        @for ($year = date('Y'); $year >= 2022; $year--)
                            <option value="{{ $year }}">
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="eForm-label">{{get_phrase('Selected Month')}}</label>
                    <select name="month" class="form-select eForm-select select2">
                        @for ($month = 1; $month <= 12; $month++)
                            <option value="{{ $month }}">
                                {{ date('F', strtotime($year . '-' . $month . '-20')) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="fpb-7">
                        <button class="btn-form mt-4">{{ get_phrase('Generate Payroll') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12 pb-3">
            <div class="eSection-wrap">
                <form action="{{ route('manager.payrollconfiguration.configure_extra_modules') }}" method="post" id="filterForm">
                @csrf
                    
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="eSection-wrap pb-3">
                
            </div>
        </div>
    </div>
@endsection
