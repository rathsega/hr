@extends('index')
@push('title', get_phrase('Holidays'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Holidays') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Holidays') }}</a></li>
                </ul>
            </div>
            
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Holidays')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('name') }}</th>
                                <th class="">{{ get_phrase('date') }}</th>
                                <th class="">{{ get_phrase('optional') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Holidays::orderBy('date')->get() as $key => $holidays)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $holidays->name }}
                                    </td>
                                    <td>
                                    {{ date("d, F, Y", strtotime($holidays->date)) }}
                                    </td>
                                    <td>
                                        {{ $holidays->optional }}
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
