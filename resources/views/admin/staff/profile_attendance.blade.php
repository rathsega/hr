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
        
        $timestamp = strtotime($selected_year . '-' . $selected_month . '-1 00:00:00');
    @endphp
    <div class="col-md-12">
        <form action="{{ route('admin.staff.profile', ['attendance', $user->id]) }}" method="get" id="filterForm">
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

    <div class="col-md-12 pb-4">
        <div class="table-responsive">
            <table class="table eTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Checkin</th>
                        <th>Checkout</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $start_timestamp = $timestamp;
                        $end_timestamp = strtotime(date('Y-m-t 23:59:59', $timestamp));
                        
                        $att_reports = App\Models\Attendance::where('user_id', $user->id)
                            ->where('checkin', '>=', $start_timestamp)
                            ->where('checkin', '<=', $end_timestamp);
                    @endphp
                    @foreach ($att_reports->get() as $key => $att_report)
                        <tr>
                            <td class="text-13px text-dark">
                                {{ date('d, M Y', $att_report->check_in) }}
                            </td>
                            <td>
                                {{ date('h:i a', $att_report->checkin) }}
                                @if ($att_report->location != '' && array_key_exists('in', json_decode($att_report->location, true)))
                                    @php $in = json_decode($att_report->location, true)['in']; @endphp
                                    @if ($in)
                                        <p class="text-dark text-11px m-0 p-0">
                                            <svg id="fi_9062151" height="15" viewBox="500 50 90 900" width="10" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                                                <g stroke="rgb(0,0,0)" stroke-miterlimit="10">
                                                    <path
                                                        d="m500 843.54a16 16 0 0 1 -13.83-8c-.57-1-57.51-98.94-114.89-201.5-117.18-209.47-122.07-233.92-123.67-242l-.06-.3-1.55-8.63c0-.09 0-.18 0-.28a260.4 260.4 0 0 1 -3.33-41.43 257.4 257.4 0 1 1 514.8 0 260.4 260.4 0 0 1 -3.33 41.43c0 .1 0 .19-.05.28l-1.57 8.71-.06.3c-1.6 8-6.49 32.49-123.67 242-57.45 102.52-114.39 200.48-114.96 201.46a16 16 0 0 1 -13.83 7.96zm-221-457.54c1.78 8.54 17.17 48.3 120.2 232.49 40.31 72 80.4 141.82 100.79 177.14 20.4-35.33 60.5-105.12 100.81-177.18 103.03-184.18 118.41-223.94 120.2-232.45l1.51-8.39a227.58 227.58 0 0 0 2.9-36.18c-.01-124.31-101.12-225.43-225.41-225.43s-225.4 101.12-225.4 225.4a227.58 227.58 0 0 0 2.9 36.18z">
                                                    </path>
                                                    <path
                                                        d="m500 479.77c-85 0-154.2-69.18-154.2-154.2s69.2-154.2 154.2-154.2 154.2 69.17 154.2 154.2-69.2 154.2-154.2 154.2zm0-276.4a122.2 122.2 0 1 0 122.2 122.2 122.33 122.33 0 0 0 -122.2-122.2z">
                                                    </path>
                                                    <path
                                                        d="m500 916c-114.53 0-230.47-30.39-230.47-88.46 0-16.9 10.35-41.23 59.66-61.21 33.18-13.45 78.9-22.64 128.77-25.89a16 16 0 1 1 2.04 31.93c-46.54 3-88.74 11.42-118.83 23.61-29.28 11.87-39.68 24.42-39.68 31.56 0 9.22 16.06 24 51.94 36.08 38.94 13.14 90.98 20.38 146.57 20.38s107.63-7.24 146.53-20.38c35.88-12.13 51.94-26.86 51.94-36.08 0-7.14-10.4-19.69-39.68-31.56-30.09-12.19-72.29-20.57-118.79-23.61a16 16 0 1 1 2-31.93c49.87 3.25 95.59 12.44 128.77 25.89 49.31 20 59.66 44.31 59.66 61.21.04 58.07-115.9 88.46-230.43 88.46z">
                                                    </path>
                                                </g>
                                            </svg>
                                            {{ $in }}
                                        </p>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if (!empty($att_report->checkout))
                                    {{ date('h:i a', $att_report->checkout) }}
                                    @if ($att_report->location != '' && array_key_exists('out', json_decode($att_report->location, true)))
                                        @php $out = json_decode($att_report->location, true)['out']; @endphp
                                        @if ($out)
                                            <p>
                                                <svg id="fi_9062151" height="15" viewBox="500 50 90 900" width="10" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
                                                    <g stroke="rgb(0,0,0)" stroke-miterlimit="10">
                                                        <path
                                                            d="m500 843.54a16 16 0 0 1 -13.83-8c-.57-1-57.51-98.94-114.89-201.5-117.18-209.47-122.07-233.92-123.67-242l-.06-.3-1.55-8.63c0-.09 0-.18 0-.28a260.4 260.4 0 0 1 -3.33-41.43 257.4 257.4 0 1 1 514.8 0 260.4 260.4 0 0 1 -3.33 41.43c0 .1 0 .19-.05.28l-1.57 8.71-.06.3c-1.6 8-6.49 32.49-123.67 242-57.45 102.52-114.39 200.48-114.96 201.46a16 16 0 0 1 -13.83 7.96zm-221-457.54c1.78 8.54 17.17 48.3 120.2 232.49 40.31 72 80.4 141.82 100.79 177.14 20.4-35.33 60.5-105.12 100.81-177.18 103.03-184.18 118.41-223.94 120.2-232.45l1.51-8.39a227.58 227.58 0 0 0 2.9-36.18c-.01-124.31-101.12-225.43-225.41-225.43s-225.4 101.12-225.4 225.4a227.58 227.58 0 0 0 2.9 36.18z">
                                                        </path>
                                                        <path
                                                            d="m500 479.77c-85 0-154.2-69.18-154.2-154.2s69.2-154.2 154.2-154.2 154.2 69.17 154.2 154.2-69.2 154.2-154.2 154.2zm0-276.4a122.2 122.2 0 1 0 122.2 122.2 122.33 122.33 0 0 0 -122.2-122.2z">
                                                        </path>
                                                        <path
                                                            d="m500 916c-114.53 0-230.47-30.39-230.47-88.46 0-16.9 10.35-41.23 59.66-61.21 33.18-13.45 78.9-22.64 128.77-25.89a16 16 0 1 1 2.04 31.93c-46.54 3-88.74 11.42-118.83 23.61-29.28 11.87-39.68 24.42-39.68 31.56 0 9.22 16.06 24 51.94 36.08 38.94 13.14 90.98 20.38 146.57 20.38s107.63-7.24 146.53-20.38c35.88-12.13 51.94-26.86 51.94-36.08 0-7.14-10.4-19.69-39.68-31.56-30.09-12.19-72.29-20.57-118.79-23.61a16 16 0 1 1 2-31.93c49.87 3.25 95.59 12.44 128.77 25.89 49.31 20 59.66 44.31 59.66 61.21.04 58.07-115.9 88.46-230.43 88.46z">
                                                        </path>
                                                    </g>
                                                </svg>
                                                {{ $out }}
                                            </p>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>

                                @if ($att_report->late_entry == 1)
                                    <span class="badge bg-warning fw-700">Late entry</span>
                                @endif

                                @if ($att_report->early_leave == 1)
                                    <span class="badge bg-danger fw-700">Early leave</span>
                                @endif

                                @if ($att_report->note)
                                    <p class="text-12px"><b>Note:</b> @php echo script_checker($att_report->note); @endphp</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
