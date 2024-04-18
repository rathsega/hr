@extends('index')
@push('title', get_phrase('Reminder Log'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex ">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Clients') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{route('admin.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{route('admin.clients')}}">{{ get_phrase('Clients') }}</a></li>
                    <li><a href="#">{{ get_phrase('Reminder Log') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Logs')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Employee name') }}</th>
                                <th class="">{{ get_phrase('Client name') }}</th>
                                <th class="">{{ get_phrase('Reminder Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $key => $log)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $log->employee }}
                                    </td>
                                    <td>
                                        {{ $log->client }}
                                    </td>
                                    <td>
                                        {{ date("d-m-Y H:i", strtotime($log->date_time)) }}
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
