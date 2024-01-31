@extends('index')
@push('title', get_phrase('System Information'))
@push('meta')
@endpush
@push('css')
    <style>
        .about tr td:last-child{
            text-align: right;
            font-weight: 600;
            color: #000;
        }
    </style>
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('System Information') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('manager.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('System Information') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 pb-3">
            <div class="eSection-wrap">
                <div class="title">
                    <h3>{{get_settings('website_title')}}</h3>
                    <p>
                        {{get_phrase('Check your system information from here')}}
                    </p>
                </div>

                <div class="pb-4">
                    @php
                        $curl_enabled = function_exists('curl_version');
                        $application_details = App\Models\Setting::get_application_details();
                    @endphp
                    <table class="table eTable about">
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Software version')}}
                            </td>
                            <td>{{get_settings('version')}}</td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Check update')}}
                            </td>
                            <td>
                                <a href="https://codecanyon.net/user/creativeitem/portfolio" target="_blank">
                                    {{get_phrase('Check Update')}}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Php version')}}
                            </td>
                            <td>{{phpversion()}}</td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Curl enabled')}}
                            </td>
                            <td>
                                @if($curl_enabled)
                                    {{get_phrase('Yes')}}
                                @else
                                    {{get_phrase('No')}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Purchase code')}}
                            </td>
                            <td>{{get_settings('purchase_code')}}</td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Product license')}}
                            </td>
                            <td>
                                <span class="badge @if($application_details['product_license'] == 'valid') bg-success @else bg-danger @endif">
                                    {{get_phrase($application_details['product_license'])}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Customer support status')}}
                            </td>
                            <td>
                                <span class="badge @if($application_details['purchase_code_status'] == 'valid') bg-success @else bg-danger @endif">
                                    {{get_phrase($application_details['purchase_code_status'])}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Support expiry date')}}
                            </td>
                            <td>
                                <span class="badge @if($application_details['support_expiry_date'] != 'invalid') bg-success @else bg-danger @endif">
                                    {{ucfirst($application_details['support_expiry_date'])}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Customer name')}}
                            </td>
                            <td>
                                <span class="badge @if($application_details['customer_name'] != 'invalid') bg-success @else bg-danger @endif">{{$application_details['customer_name']}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fi-rr-arrow-alt-square-right"></i>
                                {{get_phrase('Get customer support')}}
                            </td>
                            <td>
                                <a href="http://support.creativeitem.com" target="_blank">{{get_phrase('Customer support')}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
@endsection