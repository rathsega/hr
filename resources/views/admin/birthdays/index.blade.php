@extends('index')
@push('title', get_phrase('Birthdays'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Birthdays') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Birthdays') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Birthdays')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('name') }}</th>
                                <th class="">{{ get_phrase('date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\User::orderBy('birthday')->get() as $key => $birthdays)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $birthdays->name }}
                                    </td>
                                    <td>
                                        {{ $birthdays->birthday ? date('jS M', strtotime($birthdays->birthday)) : '' }}
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
