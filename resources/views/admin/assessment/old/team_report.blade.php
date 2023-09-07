@extends('index')

@section('content')
    <div class="eSection-wrap">
        <div class="row">
            <div class="col-md-5">
                <div class="eCard">
                    <div class="eCard-body">
                        <div class="list-group">

                            @foreach($active_staffs as $staff)    
                                <a href="{{route('admin.assessment.team.report',$staff->id )}}" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="mb-1 d-flex ">
                                            <img width="50px" height="50px" class="rounded-circle" src="{{get_image('uploads/user-image/'.$staff->photo)}}">
                                            <div class="ms-2">
                                                <h6>{{$staff->name}}</h6>
                                                <small>{{$staff->designation}}</small>
                                            </div>
                                        </div>
                                        {{-- <small>{{$staff->role}}</small> --}}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7" id="staff-report"></div>
        </div>
    </div>




@endsection
