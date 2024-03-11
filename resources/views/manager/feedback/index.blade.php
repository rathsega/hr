@extends('index')
@push('title', get_phrase('Feedback'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Feedback') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{route('staff.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Feedback') }}</a></li>
                </ul>
            </div>
            
        </div>
    </div>

    <div class="row">
                    <div class="col-md-12">


                        <form action="{{ route('manager.feedback.store') }}" method="post" enctype="multipart/form-data">
                            @Csrf

                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="fpb-7">
                                        <label for="eInputTextarea" class="eForm-label">{{get_phrase('Feedback')}}</label>
                                        <textarea class="form-control" rows="4" name="feedback" required></textarea>
                                        @if ($errors->has('feedback'))
                                            <small class="text-danger">
                                                {{ $errors->first('feedback') }}
                                            </small>
                                        @endif
                                    </div>
                                    
                                    <button type="submit" class="btn-form mt-2 mb-3">{{ get_phrase('Submit request') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
@endsection
