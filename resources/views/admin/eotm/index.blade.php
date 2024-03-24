@extends('index')
@push('title', get_phrase('Employee Of The Month'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Employee Of The Month') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="#">{{ get_phrase('Employee Of The Month') }}</a></li>
            </ul>
        </div>
        <div class="export-btn-area d-flex ">
            <a href="#" class="export_btn" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.eotm.add']) }}', '{{ __('Add Employee Of The Month') }}')">
                <i class="bi bi-plus me-2"></i>
                <span class="d-none d-sm-inline-block">{{ get_phrase('Add Employee Of The Month') }}</span>
            </a>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">
            <p class="column-title mb-2">{{get_phrase('Employee Of The Month')}}</p>
            <div class="table-responsive">
                <table class="table eTable">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">{{ get_phrase('Name') }}</th>
                            <th class="">{{ get_phrase('Month') }}</th>
                            <th class="">{{ get_phrase('Yeat') }}</th>
                            <th class="">{{ get_phrase('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eotms as $key => $eotm)
                        <tr>
                            <td>
                                {{ ++$key }}
                            </td>
                            <td>
                                {{ $eotm->name }}
                            </td>
                            <td>
                                {{ date("F", mktime(0, 0, 0, $eotm->month, 10)); }}
                            </td>
                            <td>
                                {{ $eotm->year }}
                            </td>
                            <td>
                                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.eotm.edit', 'eotm_id' => $eotm->id]) }}', '{{ __('Edit eotm') }}')" class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                        <g>
                                            <path d="m496.063 62.299-46.396-46.4c-21.199-21.199-55.689-21.198-76.888 0L27.591 361.113c-2.17 2.17-3.624 5.054-4.142 7.875L.251 494.268a15.002 15.002 0 0 0 17.48 17.482L143 488.549c2.895-.54 5.741-2.008 7.875-4.143l345.188-345.214c21.248-21.248 21.251-55.642 0-76.893zM33.721 478.276l14.033-75.784 61.746 61.75-75.779 14.034zm106.548-25.691L59.41 371.721 354.62 76.488l80.859 80.865-295.21 295.232zM474.85 117.979l-18.159 18.161-80.859-80.865 18.159-18.161c9.501-9.502 24.96-9.503 34.463 0l46.396 46.4c9.525 9.525 9.525 24.939 0 34.465z" fill="#000000" data-original="#000000" class=""></path>
                                        </g>
                                    </svg>
                                </a>

                                <a href="#" onclick="confirmModal('{{ route('admin.eotm.delete', $eotm->id) }}')" class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="15" height="15" viewBox="0 0 24 24">
                                        <path d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection