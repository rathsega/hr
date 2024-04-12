@extends('index')
@push('title', get_phrase('Late Login Report'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Late Login Report') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Late Login Report') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-8 order-md-1">
            <div class="eSection-wrap">
                <div class="row">

                    <div class="col-md-12">
                        <form action="{{ route('admin.attendance.lateloginreports') }}" method="post" id="filterForm">
                        @csrf
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="eForm-label">{{get_phrase('Select From Date')}}</label>
                                    <div class="col-md-12">
                                        <div class="fpb-7">
                                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control eForm-control" name="from_date" id="from_date" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="eForm-label">{{get_phrase('Select To Date')}}</label>
                                    <div class="col-md-12">
                                        <div class="fpb-7">
                                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control eForm-control" name="to_date" id="to_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="fpb-7">
                                        <button class="btn-form mt-4">{{ get_phrase('Download') }}</button>
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

