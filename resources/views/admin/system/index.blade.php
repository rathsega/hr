@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-7 pb-3">
            <div class="eSection-wrap">
                <div class="title">
                    <h3>{{get_phrase('System Settings')}}</h3>
                    <p>
                        {{get_phrase('Configure your website for a step-by-step pick personalization')}}
                    </p>
                </div>
                <div class="eForm-layouts">
                    <form action="{{route('admin.system.settings.update')}}" method="post">
                        @Csrf
                        <div class="fpb-7">
                            <label for="system_name" class="eForm-label">{{get_phrase('System Name')}}</label>
                            <input value="{{get_settings('system_name')}}" name="system_name" type="text" class="form-control eForm-control" id="system_name" placeholder="{{get_phrase('Enter System Name')}}" aria-label="{{get_phrase('Enter System Name')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="website_title" class="eForm-label">{{get_phrase('Website Title')}}</label>
                            <input value="{{get_settings('website_title')}}" name="website_title" type="text" class="form-control eForm-control" id="website_title" placeholder="{{get_phrase('Enter your website title')}}" aria-label="{{get_phrase('Enter your website title')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="website_description" class="eForm-label">{{get_phrase('Website Description')}}</label>
                            <textarea name="website_description" class="form-control eForm-control" id="website_description" rows="4">{{get_settings('website_description')}}</textarea>                            
                        </div>

                        <div class="fpb-7">
                            <label for="author" class="eForm-label">{{get_phrase('Author')}}</label>
                            <input value="{{get_settings('author')}}" name="author" type="text" class="form-control eForm-control" id="author" placeholder="{{get_phrase('Author')}}" aria-label="{{get_phrase('Author')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="system_email" class="eForm-label">{{get_phrase('System Email')}}</label>
                            <input value="{{get_settings('system_email')}}" name="system_email" type="email" class="form-control eForm-control" id="system_email" placeholder="{{get_phrase('Enter System Email')}}" aria-label="{{get_phrase('Enter System Email')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="phone" class="eForm-label">{{get_phrase('Phone')}}</label>
                            <input value="{{get_settings('phone')}}" name="phone" type="text" class="form-control eForm-control" id="phone" placeholder="{{get_phrase('Phone number')}}" aria-label="{{get_phrase('Phone number')}}">
                        </div>

                        <div class="fpb-7">
                            <label for="address" class="eForm-label">{{get_phrase('Address')}}</label>
                            <input value="{{get_settings('address')}}" name="address" type="text" class="form-control eForm-control" id="address" placeholder="{{get_phrase('Address')}}" aria-label="{{get_phrase('Address')}}">
                        </div>

                        {{-- <div class="fpb-7">
                            <label for="system_language" class="eForm-label">{{get_phrase('System Language')}}</label>
                            <select name="system_language" class="form-select eForm-select select2 select2-hidden-accessible" id="system_language">
                                <option value="" >{{get_phrase('Select a language')}}</option>
                            </select>
                        </div> --}}

                        <div class="fpb-7">
                            <label for="system_currency" class="eForm-label">{{get_phrase('System currency')}}</label>
                            <select name="system_currency" class="form-select eForm-select select2" id="system_currency" required>
                                <option value="">{{get_phrase('Select a currency')}}</option>
                                @foreach(App\Models\Currency::get() as $currency){
                                    <option value="{{$currency->id}}" @if($currency->id == get_settings('system_currency')) selected @endif>{{$currency->name}} ({{$currency->code}})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fpb-7">
                            <label for="purchase_code" class="eForm-label">{{get_phrase('Purchase Code')}}</label>
                            <input value="{{get_settings('purchase_code')}}" name="purchase_code" type="text" class="form-control eForm-control" id="purchase_code" placeholder="{{get_phrase('Enter your purchase code')}}" aria-label="40">
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
