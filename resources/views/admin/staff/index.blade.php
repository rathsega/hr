@extends('index')
@push('title', get_phrase('Employee'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Employee') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Employee') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area d-flex ">
                <a href="#" class="export_btn" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.staff.add']) }}', '{{ __('Add new employee') }}')">
                    <i class="bi bi-plus me-2"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new employee') }}</span>
                </a>
                <a href="#" class="export_btn ms-3"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.staff.sorting']) }}', '{{ __('Sort by drag and drop') }}')">
                    <i class="bi bi-plus me-2"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Sort') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="eCard">
        <div class="card-body">
            <ul class="nav nav-tabs eNav-Tabs-custom" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-jHome-tab" data-bs-toggle="pill" data-bs-target="#pills-jHome" type="button" role="tab" aria-controls="pills-jHome"
                        aria-selected="true">
                        Active
                        <span></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-jProfile-tab" data-bs-toggle="pill" data-bs-target="#pills-jProfile" type="button" role="tab" aria-controls="pills-jProfile"
                        aria-selected="false">
                        Inactive
                        <span></span>
                    </button>
                </li>
            </ul>
            <div class="tab-content eNav-Tabs-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-jHome" role="tabpanel" aria-labelledby="pills-jHome-tab">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($active_staffs as $active_staff)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $active_staff->photo) }}" width="40px">
                                            <div class="text-start ps-3">
                                                <p class="text-dark text-13px">{{ $active_staff->name }}</p>
                                                <small class="badge bg-secondary">{{ $active_staff->designation }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge ebg-soft-success text-capitalize">{{ $active_staff->role }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.staff.profile', ['info', $active_staff->id]) }}" class="btn btn p-0 px-1" title="View profile info"
                                            data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                                width="15" height="15" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512"
                                                xml:space="preserve" class="">
                                                <g>
                                                    <path
                                                        d="M21.5 21h-19A2.503 2.503 0 0 1 0 18.5v-13C0 4.122 1.122 3 2.5 3h19C22.878 3 24 4.122 24 5.5v13c0 1.378-1.122 2.5-2.5 2.5zM2.5 4C1.673 4 1 4.673 1 5.5v13c0 .827.673 1.5 1.5 1.5h19c.827 0 1.5-.673 1.5-1.5v-13c0-.827-.673-1.5-1.5-1.5z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                    <path
                                                        d="M7.5 12C6.122 12 5 10.878 5 9.5S6.122 7 7.5 7 10 8.122 10 9.5 8.878 12 7.5 12zm0-4C6.673 8 6 8.673 6 9.5S6.673 11 7.5 11 9 10.327 9 9.5 8.327 8 7.5 8zM11.5 17a.5.5 0 0 1-.5-.5v-1c0-.827-.673-1.5-1.5-1.5h-4c-.827 0-1.5.673-1.5 1.5v1a.5.5 0 0 1-1 0v-1C3 14.122 4.122 13 5.5 13h4c1.378 0 2.5 1.122 2.5 2.5v1a.5.5 0 0 1-.5.5zM20.5 9h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1zM20.5 13h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1zM20.5 17h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                </g>
                                            </svg>
                                        </a>

                                        <a class="btn btn p-0 px-1"
                                            onclick="confirmModal('{{ route('admin.staff.status', ['status' => 'inactive', 'user_id' => $active_staff->id]) }}')" href="#"
                                            title="Mark as inactive" data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                                width="15" height="15" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512"
                                                xml:space="preserve" fill-rule="evenodd" class="">
                                                <g>
                                                    <path
                                                        d="M15.501 2.002c-3.863 0-7 3.137-7 7 0 3.864 3.137 7 7 7s7-3.136 7-7c0-3.863-3.137-7-7-7zm0 2c2.76 0 5 2.241 5 5 0 2.76-2.24 5-5 5s-5-2.24-5-5c0-2.759 2.24-5 5-5zM3.501 28.002H16a1 1 0 0 1 0 2H2.501a1 1 0 0 1-1-1v-2a9 9 0 0 1 9-9H16a1 1 0 0 1 0 2h-5.499a7 7 0 0 0-7 7zM24.002 18.002c-3.587 0-6.499 2.912-6.499 6.499S20.415 31 24.002 31s6.499-2.912 6.499-6.499-2.912-6.499-6.499-6.499zm0 2c2.483 0 4.499 2.016 4.499 4.499S26.485 29 24.002 29s-4.499-2.016-4.499-4.499 2.016-4.499 4.499-4.499z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                    <path d="m27.177 19.901-7.775 7.775a1 1 0 0 0 1.414 1.414l7.775-7.775a.999.999 0 1 0-1.414-1.414z" fill="#000000"
                                                        data-original="#000000" class=""></path>
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.staff.edit', 'user_id' => $active_staff->id]) }}', '{{ __('Edit staff') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                                width="15" height="15" x="0" y="0" viewBox="0 0 512.001 512.001"
                                                style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                <g>
                                                    <path
                                                        d="m496.063 62.299-46.396-46.4c-21.199-21.199-55.689-21.198-76.888 0L27.591 361.113c-2.17 2.17-3.624 5.054-4.142 7.875L.251 494.268a15.002 15.002 0 0 0 17.48 17.482L143 488.549c2.895-.54 5.741-2.008 7.875-4.143l345.188-345.214c21.248-21.248 21.251-55.642 0-76.893zM33.721 478.276l14.033-75.784 61.746 61.75-75.779 14.034zm106.548-25.691L59.41 371.721 354.62 76.488l80.859 80.865-295.21 295.232zM474.85 117.979l-18.159 18.161-80.859-80.865 18.159-18.161c9.501-9.502 24.96-9.503 34.463 0l46.396 46.4c9.525 9.525 9.525 24.939 0 34.465z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('admin.staff.delete', $active_staff->id) }}')" class="btn btn p-0 px-1"
                                            title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="15" height="15" viewBox="0 0 24 24">
                                                <path
                                                    d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
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
                <div class="tab-pane fade" id="pills-jProfile" role="tabpanel" aria-labelledby="pills-jProfile-tab">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inactive_staffs as $inactive_staff)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $inactive_staff->photo) }}" width="40px">
                                            <div class="text-start ps-3">
                                                <p class="text-dark text-13px">{{ $inactive_staff->name }}</p>
                                                <small class="badge bg-secondary">{{ $inactive_staff->designation }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge ebg-soft-dark text-capitalize">{{ $inactive_staff->role }}</span>
                                    </td>
                                    <td class="text-center">

                                        <a href="{{ route('admin.staff.profile', $inactive_staff->id) }}" class="btn btn p-0 px-1" title="View profile info"
                                            data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                                width="15" height="15" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512"
                                                xml:space="preserve" class="">
                                                <g>
                                                    <path
                                                        d="M21.5 21h-19A2.503 2.503 0 0 1 0 18.5v-13C0 4.122 1.122 3 2.5 3h19C22.878 3 24 4.122 24 5.5v13c0 1.378-1.122 2.5-2.5 2.5zM2.5 4C1.673 4 1 4.673 1 5.5v13c0 .827.673 1.5 1.5 1.5h19c.827 0 1.5-.673 1.5-1.5v-13c0-.827-.673-1.5-1.5-1.5z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                    <path
                                                        d="M7.5 12C6.122 12 5 10.878 5 9.5S6.122 7 7.5 7 10 8.122 10 9.5 8.878 12 7.5 12zm0-4C6.673 8 6 8.673 6 9.5S6.673 11 7.5 11 9 10.327 9 9.5 8.327 8 7.5 8zM11.5 17a.5.5 0 0 1-.5-.5v-1c0-.827-.673-1.5-1.5-1.5h-4c-.827 0-1.5.673-1.5 1.5v1a.5.5 0 0 1-1 0v-1C3 14.122 4.122 13 5.5 13h4c1.378 0 2.5 1.122 2.5 2.5v1a.5.5 0 0 1-.5.5zM20.5 9h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1zM20.5 13h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1zM20.5 17h-6a.5.5 0 0 1 0-1h6a.5.5 0 0 1 0 1z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                </g>
                                            </svg>
                                        </a>

                                        <a class="btn btn p-0 px-1"
                                            onclick="confirmModal('{{ route('admin.staff.status', ['status' => 'active', 'user_id' => $inactive_staff->id]) }}')" href="#"
                                            title="Mark as active" data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                                width="15" height="15" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                                xml:space="preserve" class="">
                                                <g>
                                                    <path
                                                        d="M453.471 311.243c4.686 4.687 4.686 12.284 0 16.971l-67.3 67.3a12.002 12.002 0 0 1-16.97 0l-40.908-40.908c-4.686-4.687-4.686-12.284 0-16.971 4.687-4.686 12.285-4.686 16.971 0l32.422 32.423 58.815-58.815c4.686-4.685 12.284-4.686 16.97 0zM512 353.378c0 66.785-54.333 121.118-121.118 121.118a120.689 120.689 0 0 1-35.25-5.238c-50.647 24.908-101.951 37.481-152.809 37.481-7.237 0-14.458-.254-21.674-.763-58.106-4.103-116.802-24.859-174.457-61.694a11.999 11.999 0 0 1-5.483-8.956c-4.878-50.372 5.356-99.515 28.819-138.376 22.303-36.942 55.512-63.807 96.771-78.536-16.157-19.202-27.523-41.715-33.116-65.883-6.417-27.731-4.616-56.225 5.07-80.233 16.909-41.906 54.961-66.343 104.401-67.045l.17-.002.17.002c49.44.703 87.492 25.14 104.4 67.046 9.687 24.007 11.487 52.501 5.07 80.232-5.593 24.17-16.961 46.685-33.121 65.889 19.451 6.937 37.123 16.575 52.783 28.798 17.295-9.528 37.151-14.958 58.254-14.958C457.667 232.259 512 286.593 512 353.378zM153.655 212.21c16.752 16.614 33.463 25.038 49.669 25.038s32.917-8.424 49.668-25.038c35.944-35.646 49.369-89.487 32.646-130.933-13.29-32.938-42.518-51.41-82.314-52.026-39.797.616-69.025 19.088-82.315 52.026-16.722 41.447-3.298 95.288 32.646 130.933zm173.167 243.912c-34.237-21.423-57.059-59.466-57.059-102.744 0-36.614 16.333-69.484 42.093-91.712-15.062-10.636-32.135-18.728-50.973-24.154-18.65 15.756-37.969 23.737-57.559 23.737s-38.908-7.981-57.559-23.736c-81.03 23.407-127.987 96.849-121.164 189.69 101.523 63.156 200.642 72.673 302.221 28.919zM488 353.378c0-53.551-43.567-97.119-97.118-97.119s-97.119 43.567-97.119 97.119 43.567 97.118 97.119 97.118S488 406.929 488 353.378z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.staff.edit', 'user_id' => $inactive_staff->id]) }}', '{{ __('Edit staff') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                                width="15" height="15" x="0" y="0" viewBox="0 0 512.001 512.001"
                                                style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                <g>
                                                    <path
                                                        d="m496.063 62.299-46.396-46.4c-21.199-21.199-55.689-21.198-76.888 0L27.591 361.113c-2.17 2.17-3.624 5.054-4.142 7.875L.251 494.268a15.002 15.002 0 0 0 17.48 17.482L143 488.549c2.895-.54 5.741-2.008 7.875-4.143l345.188-345.214c21.248-21.248 21.251-55.642 0-76.893zM33.721 478.276l14.033-75.784 61.746 61.75-75.779 14.034zm106.548-25.691L59.41 371.721 354.62 76.488l80.859 80.865-295.21 295.232zM474.85 117.979l-18.159 18.161-80.859-80.865 18.159-18.161c9.501-9.502 24.96-9.503 34.463 0l46.396 46.4c9.525 9.525 9.525 24.939 0 34.465z"
                                                        fill="#000000" data-original="#000000" class=""></path>
                                                </g>
                                            </svg>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('admin.staff.delete', $inactive_staff->id) }}')" class="btn btn p-0 px-1"
                                            title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                            <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="15" height="15" viewBox="0 0 24 24">
                                                <path
                                                    d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
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
