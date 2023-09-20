<div class="row">
    @php
        if (isset($_GET['year'])) {
            $selected_year = $_GET['year'];
        } else {
            $selected_year = date('Y');
        }

    @endphp
    <div class="col-md-12">
        <form action="{{ route('staff.my.profile', 'assessment') }}" method="get" id="filterForm">
            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="eForm-label">Selected Year</label>
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

    <div class="col-md-12 pb-4">
        <div class="table-responsive">
            <table class="table eTable">
                <thead>
                    <th class="w-180px">{{ get_phrase('Assessment Date') }}</th>
                    <th>{{ get_phrase('Assessment') }}</th>
                </thead>
                <tbody>
                    @php
                        $incidents = App\Models\Assessment::where('user_id', $user->id)
                            ->whereDate('created_at', '>=', $selected_year . '-1-1 00:00:00')
                            ->whereDate('created_at', '<=', $selected_year . '-12-31 23:59:59')
                            ->orderby('created_at', 'desc')
                            ->get();
                        $pre_date = '';
                    @endphp
                    @foreach ($incidents as $key => $incident)

                        @php
                            $timestamp = strtotime($incident->created_at);
                            $rowspan = App\Models\Assessment::where('user_id', $user->id)
                            ->whereDate('created_at', '>=', date('Y-m-d 00:00:00', $timestamp))
                            ->whereDate('created_at', '<=', date('Y-m-d 23:59:59', $timestamp))->count();
                            if($pre_date == date('d-M-Y', $timestamp)){
                                $rowspan = 0;
                            }
                            $pre_date = date('d-M-Y', $timestamp);
                        @endphp

                        <tr>
                            @if($rowspan > 0)
                                <td class="align-baseline p-0 py-2" rowspan="{{$rowspan}}">
                                    {{ date('d M Y', $incident->date_time) }}
                                </td>
                            @endif

                            <td class="ps-3 align-baseline p-0">
                                {!! script_checker($incident->description) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
