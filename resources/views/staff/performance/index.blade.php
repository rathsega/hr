@extends('index')
@push('title', get_phrase('Performance'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Performance') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{route('admin.dashboard')}}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Performance') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Monthly Reviews')}}</p>
                <div class="row">

                    @php
                        if (isset($_GET['year'])) {
                            $selected_year = $_GET['year'];
                        } else {
                            $selected_year = date('Y');
                        }
                        $timestamp = strtotime($selected_year . '-1-1 00:00:00');
                    @endphp

                    <div class="col-md-12">
                        <form action="{{ route('staff.performance') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="eForm-label">{{get_phrase('Selected Year')}}</label>
                                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select select2">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}" @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table eTable">
                                <thead>
                                    <tr>
                                        <th class="">{{get_phrase('Month')}}</th>
                                        <th class="">{{get_phrase('Reviews')}}</th>
                                        <th class="">{{get_phrase('Remarks')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $performance_reviews = App\Models\Performance::whereDate('created_at', '>=', date('Y-1-1 00:00:00', $timestamp))
                                            ->whereDate('created_at', '<=', date('Y-12-31 23:59:59', $timestamp))
                                            ->where('user_id', auth()->user()->id);
                                    @endphp
                                    @foreach ($performance_reviews->get() as $performance_review)
                                        @php
                                            $remarks = $performance_review->remarks;
                                            $ratings = json_decode($performance_review->ratings, true);
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                {{date('M Y', strtotime($performance_review->created_at))}}
                                            </td>
                                            <td>
                                                <div class="row">
                                                    @foreach ($performance_types as $performance_type)
                                                        <div class="col-12">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if (count($ratings) > 0 && array_key_exists($performance_type->slug, $ratings) && $i <= $ratings[$performance_type->slug])
                                                                    <i class="bi bi-star-fill text-warning"></i>
                                                                @elseif(count($ratings) > 0 && array_key_exists($performance_type->slug, $ratings))
                                                                    <i class="bi bi-star-fill"></i>
                                                                @else
                                                                    <i class="bi bi-star"></i>
                                                                @endif
                                                            @endfor
                                                            <span>{{ $performance_type->title }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="position-relative">
                                                {{ $remarks }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
