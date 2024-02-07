@extends('index')
@push('title', get_phrase('Upload Users'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Upload Users') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="#">{{ get_phrase('Upload Users') }}</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form action="{{route('admin.uploadusers.store')}}" method="post" enctype="multipart/form-data">
            @Csrf


            <div class="fpb-7 col-md-6">
                <label for="users" class="eForm-label">{{get_phrase('Choose Template')}}</label>
                <input type="file" name="users" class="form-control eForm-control-file" id="users" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
            </div>

            <button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Apply')}}</button>
        </form>

        @include('init')
    </div>
</div>
@endsection