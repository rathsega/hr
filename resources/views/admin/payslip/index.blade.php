@extends('index')
@push('title', get_phrase('Payslip'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Payslip') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Payslip') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Monthly payslip')}}</p>
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
                        <form action="{{ route('admin.payslip') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="eForm-label">{{get_phrase('Selected Year')}}</label>
                                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select select2">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}" @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="eForm-label">{{get_phrase('Selected Month')}}</label>
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
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table eTable">
                                <thead>
                                    <tr>
                                        <th class="">Employee</th>
                                        <th class="text-center">{{get_phrase('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @php
                                            $payslip = \App\Models\Payslip::where('user_id', $user->id)->whereDate('month_of_salary', $selected_year . '-' . $selected_month . '-1 00:00:00');
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center">
                                                    <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $user->photo) }}" width="40px">
                                                    <div class="text-start ps-3">
                                                        <p class="text-dark text-13px">
                                                            {{ $user->name }}
                                                            @if ($payslip->value('email_sent') > 0)
                                                                <span title="{{ get_phrase('Payslip sent') }}" data-bs-toggle="tooltip">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                        xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0"
                                                                        viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                                        <g>
                                                                            <path fill="#4bae4f" fill-rule="evenodd"
                                                                                d="M256 0C114.8 0 0 114.8 0 256s114.8 256 256 256 256-114.8 256-256S397.2 0 256 0z" clip-rule="evenodd"
                                                                                data-original="#4bae4f" class=""></path>
                                                                            <path fill="#ffffff"
                                                                                d="M206.7 373.1c-32.7-32.7-65.2-65.7-98-98.4-3.6-3.6-3.6-9.6 0-13.2l37.7-37.7c3.6-3.6 9.6-3.6 13.2 0l53.9 53.9L352.1 139c3.7-3.6 9.6-3.6 13.3 0l37.8 37.8c3.7 3.7 3.7 9.6 0 13.2L219.9 373.1c-3.6 3.7-9.5 3.7-13.2 0z"
                                                                                data-original="#ffffff" class=""></path>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                        </p>
                                                        <small class="badge bg-secondary">{{ $user->designation }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($payslip->count() == 0)
                                                    <!-- <a href="{{ route('admin.payslip', ['user_id' => $user->id, 'year' => $selected_year, 'month' => $selected_month]) }}"
                                                        class="btn btn p-0 px-1" title="{{ get_phrase('Generate Invoice') }}" data-bs-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0"
                                                            viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M405.332 192H234.668V21.332C234.668 9.559 225.109 0 213.332 0 201.559 0 192 9.559 192 21.332V192H21.332C9.559 192 0 201.559 0 213.332c0 11.777 9.559 21.336 21.332 21.336H192v170.664c0 11.777 9.559 21.336 21.332 21.336 11.777 0 21.336-9.559 21.336-21.336V234.668h170.664c11.777 0 21.336-9.559 21.336-21.336 0-11.773-9.559-21.332-21.336-21.332zm0 0"
                                                                    fill="#000000" data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </a> -->
                                                @else
                                                    <a href="{{ route('admin.payslip.viewPayslip', ['id' => $payslip->value('id')]) }}" class="btn btn p-0 px-1" target="_blank"
                                                        title="{{ get_phrase('View Payslip') }}" data-bs-toggle="tooltip">
                                                        <i class="fi-rr-blog-pencil"></i>
                                                    </a>

                                                    <!-- <a href="#"
                                                        onclick="confirmModal('{{ route('admin.payslip.send', ['invoice_id' => $payslip->value('id'), 'user_id' => $user->id]) }}')"
                                                        class="btn btn p-0 px-1" title="{{ get_phrase('Send Payslip') }}" data-bs-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" id="fi_2907795" data-name="Layer 1" viewBox="0 0 24 24" width="18"
                                                            height="18">
                                                            <path
                                                                d="M14.76,22.65a2.3,2.3,0,0,1-2-1.23L9.28,15.06a.8.8,0,0,0-.34-.34L2.58,11.29A2.34,2.34,0,0,1,3,7L19.57,1.47h0a2.35,2.35,0,0,1,3,3L17,21.05a2.31,2.31,0,0,1-2,1.59ZM20,2.9,3.43,8.43a.84.84,0,0,0-.58.73.83.83,0,0,0,.44.81L9.65,13.4a2.29,2.29,0,0,1,.95.95L14,20.71a.83.83,0,0,0,.81.44.84.84,0,0,0,.73-.58L21.1,4A.84.84,0,0,0,20,2.9Z">
                                                            </path>
                                                            <path
                                                                d="M9.67,15.08a.71.71,0,0,1-.53-.22.74.74,0,0,1,0-1.06L20.9,2A.75.75,0,0,1,22,3.1L10.2,14.86A.74.74,0,0,1,9.67,15.08Z">
                                                            </path>
                                                        </svg>
                                                    </a> -->

                                                    <a href="{{ route('admin.payslip.download_new_payslip', ['id' => $payslip->value('id')]) }}"
                                                        class="btn btn p-0 px-1" title="{{ get_phrase('Download Payslip') }}" data-bs-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="18" version="1.1" viewBox="-53 1 511 511.99906" width="18"
                                                            id="fi_1092004">
                                                            <g id="surface1">
                                                                <path
                                                                    d="M 276.410156 3.957031 C 274.0625 1.484375 270.84375 0 267.507812 0 L 67.777344 0 C 30.921875 0 0.5 30.300781 0.5 67.152344 L 0.5 444.84375 C 0.5 481.699219 30.921875 512 67.777344 512 L 338.863281 512 C 375.71875 512 406.140625 481.699219 406.140625 444.84375 L 406.140625 144.941406 C 406.140625 141.726562 404.65625 138.636719 402.554688 136.285156 Z M 279.996094 43.65625 L 364.464844 132.328125 L 309.554688 132.328125 C 293.230469 132.328125 279.996094 119.21875 279.996094 102.894531 Z M 338.863281 487.265625 L 67.777344 487.265625 C 44.652344 487.265625 25.234375 468.097656 25.234375 444.84375 L 25.234375 67.152344 C 25.234375 44.027344 44.527344 24.734375 67.777344 24.734375 L 255.261719 24.734375 L 255.261719 102.894531 C 255.261719 132.945312 279.503906 157.0625 309.554688 157.0625 L 381.40625 157.0625 L 381.40625 444.84375 C 381.40625 468.097656 362.113281 487.265625 338.863281 487.265625 Z M 338.863281 487.265625 "
                                                                    style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;"></path>
                                                                <path
                                                                    d="M 305.101562 401.933594 L 101.539062 401.933594 C 94.738281 401.933594 89.171875 407.496094 89.171875 414.300781 C 89.171875 421.101562 94.738281 426.667969 101.539062 426.667969 L 305.226562 426.667969 C 312.027344 426.667969 317.59375 421.101562 317.59375 414.300781 C 317.59375 407.496094 312.027344 401.933594 305.101562 401.933594 Z M 305.101562 401.933594 "
                                                                    style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;"></path>
                                                                <path
                                                                    d="M 194.292969 357.535156 C 196.644531 360.007812 199.859375 361.492188 203.320312 361.492188 C 206.785156 361.492188 210 360.007812 212.347656 357.535156 L 284.820312 279.746094 C 289.519531 274.796875 289.148438 266.882812 284.203125 262.308594 C 279.253906 257.609375 271.339844 257.976562 266.765625 262.925781 L 215.6875 317.710938 L 215.6875 182.664062 C 215.6875 175.859375 210.121094 170.296875 203.320312 170.296875 C 196.519531 170.296875 190.953125 175.859375 190.953125 182.664062 L 190.953125 317.710938 L 140 262.925781 C 135.300781 257.980469 127.507812 257.609375 122.5625 262.308594 C 117.617188 267.007812 117.246094 274.800781 121.945312 279.746094 Z M 194.292969 357.535156 "
                                                                    style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;"></path>
                                                            </g>
                                                        </svg>
                                                    </a>


                                                    
                                                @endif
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


        <div class="col-md-4">
            @if (isset($_GET['user_id']) && $_GET['user_id'] > 0)
                @include('admin.payslip.add')
            @endif
            @if (isset($_GET['id']) && $_GET['id'] > 0)
                @include('admin.payslip.edit')
            @endif
        </div>
    </div>
@endsection
