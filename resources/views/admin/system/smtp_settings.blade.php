@extends('index')
@push('title', get_phrase('SMTP Settings'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('SMTP Settings') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('SMTP Settings') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 pb-3">
            <div class="eSection-wrap">
                <div class="title">
                    <h3>{{get_phrase('SMTP Settings')}}</h3>
                    <p>
                        {{get_phrase('Configure the SMTP settings to send mail from your website for any type of email.')}}
                    </p>
                </div>
                <div class="eForm-layouts">
                    <form action="{{route('admin.smtp.settings.update')}}" method="post">
                        @Csrf
                        @php
                            $smtp = get_settings('smtp_settings', true);
                        @endphp
                        
                        <div class="fpb-7">
                            <label for="protocol" class="eForm-label">{{get_phrase('Protocol')}}  <small>(smtp or mail)</small></label>
                            <input value="{{$smtp['protocol']}}" name="smtp_settings[protocol]" type="text" class="form-control eForm-control" id="protocol" placeholder="{{get_phrase('Enter SMTP Protocol')}}" aria-label="{{get_phrase('Enter SMTP Protocol')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="security" class="eForm-label">{{get_phrase('Security')}} <small>(ssl or tls)</small></label>
                            <input value="{{$smtp['security']}}" name="smtp_settings[security]" type="text" class="form-control eForm-control" id="security">
                        </div>

                        <div class="fpb-7">
                            <label for="host" class="eForm-label">{{get_phrase('SMTP Host')}}</label>
                            <input value="{{$smtp['host']}}" name="smtp_settings[host]" type="text" class="form-control eForm-control" id="host">
                        </div>

                        <div class="fpb-7">
                            <label for="port" class="eForm-label">{{get_phrase('SMTP Port')}}</label>
                            <input value="{{$smtp['port']}}" name="smtp_settings[port]" type="text" class="form-control eForm-control" id="port" placeholder="{{get_phrase('SMTP Port')}}" aria-label="{{get_phrase('SMTP Port')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="from_email" class="eForm-label">{{get_phrase('From Email')}}</label>
                            <input value="{{$smtp['from_email']}}" name="smtp_settings[from_email]" type="text" class="form-control eForm-control" id="from_email" placeholder="{{get_phrase('Enter From Email')}}" aria-label="{{get_phrase('Enter From Email')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="username" class="eForm-label">{{get_phrase('Username')}}</label>
                            <input value="{{$smtp['username']}}" name="smtp_settings[username]" type="text" class="form-control eForm-control" id="username" placeholder="{{get_phrase('SMTP Username')}}" aria-label="{{get_phrase('SMTP Username')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="password" class="eForm-label">{{get_phrase('Password')}}</label>
                            <input value="{{$smtp['password']}}" name="smtp_settings[password]" type="text" class="form-control eForm-control" id="password" placeholder="{{get_phrase('Password')}}" aria-label="{{get_phrase('Password')}}">
                        </div>

                        <div class="fpb-7">
                            <button class="btn-form mt-2 mb-3">{{get_phrase('Save Changes')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
