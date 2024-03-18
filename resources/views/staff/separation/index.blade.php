@extends('index')
@push('title', get_phrase('Separation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

<div class="mainSection-title">
    @php
    $separations = DB::table('separation')->where('user_id',auth()->user()->id)->get();
    $separation_existed = 0;
    if(!$separations->isEmpty()){
    $status = ["Pending at Manager",
    "Rejected by Manager",
    "Approved by Manager",
    "Pending at IT Manager",
    "Rejected by IT Manager",
    "Approved by IT Manager",
    "Pending at Finance Manager",
    "Rejected by Finance Manager",
    "Approved by Finance Manager",
    "Pending at HR Manager"];
    if(in_array($separations[0]->status, $status)){
    $separation_existed = 1;
    }else{
    $separation_existed = 0;
    }
    }else{
    $separation_existed = 0;
    }
    @endphp
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Separation') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="{{route('staff.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="#">{{ get_phrase('Separation') }}</a></li>
            </ul>
        </div>
        @if(!$separation_existed )
        <div class="export-btn-area d-flex ">
            <a href="#" class="export_btn" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'staff.separation.add']) }}', '{{ __('Separation Details') }}')">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14.046" height="12.29" viewBox="0 0 14.046 12.29">
                        <path id="Logout" d="M4.389,42.535H2.634a.878.878,0,0,1-.878-.878V34.634a.878.878,0,0,1,.878-.878H4.389a.878.878,0,0,0,0-1.756H2.634A2.634,2.634,0,0,0,0,34.634v7.023A2.634,2.634,0,0,0,2.634,44.29H4.389a.878.878,0,1,0,0-1.756Zm9.4-5.009-3.512-3.512a.878.878,0,0,0-1.241,1.241l2.015,2.012H5.267a.878.878,0,0,0,0,1.756H11.05L9.037,41.036a.878.878,0,1,0,1.241,1.241l3.512-3.512A.879.879,0,0,0,13.788,37.525Z" transform="translate(0 -32)" fill="#fff" />
                    </svg>
                </span>
                &nbsp;{{get_phrase(' Exit From The Organization')}}
            </a>
        </div>
        @endif

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">
            <p class="column-title mb-2">{{get_phrase('Separations')}}</p>
            <div class="table-responsive">
                <table class="table eTable">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">{{ get_phrase('Initiated Date') }}</th>
                            <th class="">{{ get_phrase('Last Working Day') }}</th>
                            <th class="">{{ get_phrase('Status') }}</th>
                            <th class="">{{ get_phrase('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$separations->isEmpty())
                        @foreach ($separations as $key => $separation)
                        <tr>
                            <td>
                                {{ ++$key }}
                            </td>
                            <td>
                                {{ date('d-m-Y H:i', strtotime($separation->initiated_date)) }}
                            </td>
                            <td>
                                {{ date('d-m-Y', strtotime($separation->actual_last_working_day)) }}
                            </td>
                            <td>
                                {{ $separation->status }}
                            </td>
                            <td>
                                <a href="{{ route('staff.separation.view', $separation->id) }}" class="btn btn p-0 px-1" title="View Separation"
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
                                @if($separation->status != 'Relieved' && $separation->status != 'Revoked')
                                    <a href="{{ route('staff.separation.revoke', $separation->id) }}" type="button" class="btn px-1 py-0" title="{{ get_phrase('Revoke') }}"
                                        data-bs-toggle="tooltip">
                                        <svg fill="none" height="14" viewBox="0 0 24 24" width="14" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="fi_8929802">
                                            <clipPath id="clip0_11_1220">
                                                <path d="m0 0h24v24h-24z"></path>
                                            </clipPath>
                                            <g clip-path="url(#clip0_11_1220)">
                                                <path
                                                    d="m14 12c0-1.1-.9-2.00005-2-2.00005s-2 .90005-2 2.00005.9 2 2 2 2-.9 2-2zm-1.74-9.00005c-5.09-.14-9.26 3.95-9.26 9.00005h-1.79c-.45 0-.67.54-.35.85l2.79 2.79c.2.2.51.2.71 0l2.79-2.79c.31-.31.09-.85-.36-.85h-1.79c0-3.90005 3.18-7.05005 7.1-7.00005 3.72.05 6.85 3.18 6.9 6.90005.05 3.9099-3.1 7.1-7 7.1-1.25 0-2.42-.34-3.44-.91-.39-.22-.87-.14-1.18.18-.46.46-.37 1.25.2 1.57 1.31.73 2.81 1.16 4.42 1.16 5.05 0 9.14-4.17 9-9.26-.13-4.69005-4.05-8.61005-8.74-8.74005z"
                                                    fill="#000"></path>
                                            </g>
                                        </svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

