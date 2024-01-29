<div class="row">
    @php
        if (isset($_GET['year'])) {
            $selected_year = $_GET['year'];
        } else {
            $selected_year = date('Y');
        }
    @endphp

    <div class="col-md-12">
        <form action="{{ route('admin.my.profile', 'performance') }}" method="get" id="filterForm">
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
                        <th class="">{{get_phrase('Ratings')}}</th>
                        <th class="">{{get_phrase('Remarks')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $performance_reviews = App\Models\Performance::whereDate('created_at', '>=', $selected_year.'-1-1 00:00:00')
                                ->whereDate('created_at', '<=', $selected_year.'-12-31 23:59:59')
                                ->where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')->get();
                    @endphp
                    @foreach ($performance_reviews as $performance_review)
                        @php
                            $remarks = $performance_review->remarks;
                            $ratings = json_decode($performance_review->ratings, true);
                        @endphp
                        <tr>
                            <td class="min-w-100px">
                                {{date('M Y', strtotime($performance_review->created_at))}}
                            </td>

                            <td>
                                <div class="row">
                                    @foreach (App\Models\Performance_type::get() as $performance_type)
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