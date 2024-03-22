@extends('index')
@push('title', get_phrase('Announcements'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Announcements') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="#">{{ get_phrase('Announcements') }}</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="eSection-wrap">
            <p class="column-title mb-2">{{get_phrase('Announcements')}}</p>
            <div class="table-responsive">
                <table class="table eTable">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">{{ get_phrase('subject') }}</th>
                            <th class="">{{ get_phrase('message') }}</th>
                            <th class="">{{ get_phrase('department') }}</th>
                            <th class="">{{ get_phrase('date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($announcements as $key => $announcement)
                        <tr>
                            <td>
                                {{ ++$key }}
                            </td>
                            <td>
                                {{ $announcement->subject }}
                            </td>
                            <td>
                                {{ $announcement->message }}
                            </td>
                            <td>
                                {{ $announcement->title }}
                            </td>
                            <td>
                                {{ $announcement->updated_at ? date('jS M, Y', strtotime($announcement->updated_at)) : '' }}
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