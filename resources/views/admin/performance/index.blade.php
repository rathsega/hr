@extends('index')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="eSection-wrap">
                <p class="column-title mb-2">Monthly Reviews</p>
                <div class="row">

                    @php
                        if (isset($_GET['year'])) {
                            $selected_year = $_GET['year'];
                        } else {
                            $selected_year = date('Y');
                        }
                        
                        if (isset($_GET['month'])) {
                            $selected_month = $_GET['month'];
                        } else {
                            $selected_month = date('m');
                        }
                        
                        $timestamp_of_first_date = strtotime($selected_year . '-' . $selected_month . '-1');
                        $total_days_of_this_month = date('t', $timestamp_of_first_date);
                    @endphp

                    <div class="col-md-12">
                        <form action="{{ route('admin.performance') }}" method="get" id="filterForm">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Year</label>
                                    <select onchange="$('#filterForm').submit();" name="year" class="form-select eForm-select eChoice-multiple-without-remove">
                                        @for ($year = date('Y'); $year >= 2022; $year--)
                                            <option value="{{ $year }}" @if ($selected_year == $year) selected @endif>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="eForm-label">Selected Month</label>
                                    <select onchange="$('#filterForm').submit();" name="month" class="form-select eForm-select eChoice-multiple-without-remove">
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value="{{ $month }}" @if ($selected_month == $month) selected @endif>
                                                {{ date('F', strtotime($year . '-' . $month . '-20')) }}
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
                                        <th class="">Employee</th>
                                        <th class="">Reviews</th>
                                        <th class="">Remarks</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @php
                                            $performance_review = App\Models\Performance::whereDate('created_at', '>=', date('Y-m-1 00:00:00', $timestamp_of_first_date))
                                                ->whereDate('created_at', '<=', date('Y-m-' . $total_days_of_this_month . ' 23:59:59', $timestamp_of_first_date))
                                                ->where('user_id', $user->id);
                                            if ($performance_review = $performance_review->first()) {
                                                $remarks = $performance_review->remarks;
                                                $ratings = json_decode($performance_review->ratings, true);
                                            } else {
                                                $remarks = '';
                                                $ratings = [];
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center">
                                                    <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $user->photo) }}" width="40px">
                                                    <div class="text-start ps-3">
                                                        <p class="text-dark text-13px">{{ $user->name }}</p>
                                                        <small class="badge bg-secondary">{{ $user->designation }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    @foreach ($performance_types as $performance_type)
                                                        <div class="col-12">
                                                            <span>{{ $performance_type->title }}:</span>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if (count($ratings) > 0 && array_key_exists($performance_type->slug, $ratings) && $i <= $ratings[$performance_type->slug])
                                                                    <i class="bi bi-star-fill text-warning"></i>
                                                                @elseif(count($ratings) > 0 && array_key_exists($performance_type->slug, $ratings))
                                                                    <i class="bi bi-star-fill"></i>
                                                                @else
                                                                    <i class="bi bi-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>{{ $remarks }}</td>
                                            <td class="text-center">
                                                @if (!$performance_review)
                                                    <a href="{{ route('admin.performance', ['user_id' => $user->id, 'year' => $selected_year, 'month' => $selected_month]) }}"
                                                        class="btn btn p-0 px-1" title="{{ get_phrase('Give rating') }}" data-bs-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0"
                                                            viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M405.332 192H234.668V21.332C234.668 9.559 225.109 0 213.332 0 201.559 0 192 9.559 192 21.332V192H21.332C9.559 192 0 201.559 0 213.332c0 11.777 9.559 21.336 21.332 21.336H192v170.664c0 11.777 9.559 21.336 21.332 21.336 11.777 0 21.336-9.559 21.336-21.336V234.668h170.664c11.777 0 21.336-9.559 21.336-21.336 0-11.773-9.559-21.332-21.336-21.332zm0 0"
                                                                    fill="#000000" data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.performance', ['id' => $performance_review->id, 'user_id' => $user->id]) }}" class="btn btn p-0 px-1"
                                                        title="{{ get_phrase('Edit Invoice') }}" data-bs-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                            xmlns:svgjs="http://svgjs.com/svgjs" width="15" height="15" x="0" y="0"
                                                            viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="m496.063 62.299-46.396-46.4c-21.199-21.199-55.689-21.198-76.888 0L27.591 361.113c-2.17 2.17-3.624 5.054-4.142 7.875L.251 494.268a15.002 15.002 0 0 0 17.48 17.482L143 488.549c2.895-.54 5.741-2.008 7.875-4.143l345.188-345.214c21.248-21.248 21.251-55.642 0-76.893zM33.721 478.276l14.033-75.784 61.746 61.75-75.779 14.034zm106.548-25.691L59.41 371.721 354.62 76.488l80.859 80.865-295.21 295.232zM474.85 117.979l-18.159 18.161-80.859-80.865 18.159-18.161c9.501-9.502 24.96-9.503 34.463 0l46.396 46.4c9.525 9.525 9.525 24.939 0 34.465z"
                                                                    fill="#000000" data-original="#000000" class=""></path>
                                                            </g>
                                                        </svg>
                                                    </a>

                                                    <a href="#" onclick="confirmModal('{{ route('admin.performance.delete', ['id' => $performance_review->id]) }}')"
                                                        class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                                        <svg xmlns="http://www.w3.org/2000/svg" id="fi_3405244" data-name="Layer 2" width="15" height="15" viewBox="0 0 24 24">
                                                            <path
                                                                d="M19,7a1,1,0,0,0-1,1V19.191A1.92,1.92,0,0,1,15.99,21H8.01A1.92,1.92,0,0,1,6,19.191V8A1,1,0,0,0,4,8V19.191A3.918,3.918,0,0,0,8.01,23h7.98A3.918,3.918,0,0,0,20,19.191V8A1,1,0,0,0,19,7Z">
                                                            </path>
                                                            <path d="M20,4H16V2a1,1,0,0,0-1-1H9A1,1,0,0,0,8,2V4H4A1,1,0,0,0,4,6H20a1,1,0,0,0,0-2ZM10,4V3h4V4Z">
                                                            </path>
                                                            <path d="M11,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                            <path d="M15,17V10a1,1,0,0,0-2,0v7a1,1,0,0,0,2,0Z"></path>
                                                        </svg>
                                                    </a>
                                                @endif
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


        <div class="col-md-4">
            @if (isset($_GET['user_id']))
                <div class="eSection-wrap">
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $id = isset($_GET['id']) ? $_GET['id']:'0';
                                $user_id = isset($_GET['user_id']) ? $_GET['user_id']:'0';
                                $performance_review = App\Models\Performance::where('id', $id)->where('user_id', $user_id);
                                if ($performance_review = $performance_review->first()) {
                                    $remarks = $performance_review->remarks;
                                    $ratings = json_decode($performance_review->ratings, true);
                                    $route = route('admin.performance.update', $id);
                                } else {
                                    $remarks = '';
                                    $ratings = [];
                                    $route = route('admin.performance.store');
                                }
                            @endphp

                            <form action="{{ $route }}" method="post">
                                @Csrf
                                @php
                                    $pay_to = \App\Models\User::where('id', $_GET['user_id'])->first();
                                @endphp
                                <input type="hidden" value="{{ $_GET['user_id'] }}" name="user_id">
                                <input type="hidden" value="{{ date('Y-m-d H:i:s', $timestamp_of_first_date) }}" name="created_at">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center mt-3">
                                            <img class="rounded-circle" src="{{ get_image('uploads/user-image/' . $pay_to->photo) }}" width="40px">
                                            <div class="text-start ps-3">
                                                <p class="text-dark text-13px">{{ $pay_to->name }}</p>
                                                <small class="">{{ $pay_to->email }}</small>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    @foreach (App\Models\Performance_type::get() as $performance_type)
                                        <div class="col-md-12">
                                            <div class="fpb-7 d-flex">
                                                <label for="net_salary" class="eForm-label col-4">{{ $performance_type->title }}: </label>
                                                <select name="ratings[{{ $performance_type->slug }}]" class="form-control"
                                                    style="height: 27px; padding: 0px 12px; font-size: 12px;">
                                                    <option value="5" @if(array_key_exists($performance_type->slug, $ratings) && $ratings[$performance_type->slug] == 5) selected @endif>5 Start</option>
                                                    <option value="4" @if(array_key_exists($performance_type->slug, $ratings) && $ratings[$performance_type->slug] == 4) selected @endif>4 Start</option>
                                                    <option value="3" @if(array_key_exists($performance_type->slug, $ratings) && $ratings[$performance_type->slug] == 3) selected @endif>3 Start</option>
                                                    <option value="2" @if(array_key_exists($performance_type->slug, $ratings) && $ratings[$performance_type->slug] == 2) selected @endif>2 Start</option>
                                                    <option value="1" @if(array_key_exists($performance_type->slug, $ratings) && $ratings[$performance_type->slug] == 1) selected @endif>1 Start</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-md-12">
                                        <div class="fpb-7">
                                            <label for="eInputTextarea" class="eForm-label">Remarks <small class="text-muted">(Optional)</small></label>
                                            <textarea name="remarks" class="form-control" rows="2">{{ $remarks }}</textarea>
                                        </div>
                                        <button type="submit" class="btn-form mt-2 mb-3 w-100">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
