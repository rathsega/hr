@extends('index')
@push('title', get_phrase('Categories'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-7 pb-3">
            <div class="eSection-wrap">
                <div class="title">
                    <h3>{{get_phrase('Account Settings')}}</h3>
                    <p>
                        {{get_phrase('Change your account password')}}
                    </p>
                </div>
                <div class="eForm-layouts">
                    <form action="{{route('admin.password.update')}}" method="post">
                        @Csrf
                        @php
                            $profile_details = App\Models\User::where('id', auth()->user()->id)->first();
                        @endphp
                        
                        <div class="fpb-7">
                            <label for="current_password" class="eForm-label">{{get_phrase('Current Password')}}</label>
                            <input name="current_password" type="password" class="form-control eForm-control" id="current_password" placeholder="{{get_phrase('Enter your current password')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="new_password" class="eForm-label">{{get_phrase('New Password')}}</label>
                            <input name="new_password" type="password" class="form-control eForm-control" id="new_password" placeholder="{{get_phrase('Enter a new password')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="confirm_new_password" class="eForm-label">{{get_phrase('Confirm New Password')}}</label>
                            <input name="confirm_new_password" type="password" class="form-control eForm-control" id="confirm_new_password" placeholder="{{get_phrase('Confirm your new password')}}">
                        </div>

                        <div class="fpb-7">
                            <button class="btn-form mt-2 mb-3 px-3">{{get_phrase('Change Password')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
