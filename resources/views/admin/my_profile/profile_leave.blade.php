<div class="row">
    @php
        if (isset($_GET['year'])) {
            $selected_year = $_GET['year'];
        } else {
            $selected_year = date('Y');
        }
    @endphp
    <div class="col-md-12">
        <form action="{{ route('admin.my.profile', 'leave') }}" method="get" id="filterForm">
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

    <div class="col-md-12 pb-4">
        <div class="table-responsive">
            <table class="table eTable">
                <thead>
                    <tr>
                        <th>{{get_phrase('Date')}}</th>
                        <th>{{get_phrase('Reason')}}</th>
                        <th>{{get_phrase('Status')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $leave_reports = App\Models\Leave_application::where('user_id', $user->id)
                            ->where('from_date', '>=', strtotime($selected_year . '-1-1 00:00:00'))
                            ->where('to_date', '<=', strtotime($selected_year . '-12-31 23:59:59'))
                            ->orderBy('from_date');
                    @endphp
                    @foreach ($leave_reports->get() as $leave_report)
                        <tr>
                            <td class="w-255px">
                                @if (date('d M Y', $leave_report->from_date) == date('d M Y', $leave_report->to_date))
                                    {{ date('d M Y', $leave_report->from_date) }}
                                    <hr class="my-0">
                                    {{ date('h:i A', $leave_report->from_date) }} - {{ date('h:i A', $leave_report->to_date) }}
                                @else
                                    {{ date('d M Y, h:i A', $leave_report->from_date) }}
                                    <hr class="my-0">
                                    {{ date('d M Y, h:i A', $leave_report->to_date) }}
                                @endif
                            </td>
                            <td>
                                @php echo script_checker($leave_report->reason); @endphp

                                @if ($leave_report->attachment)
                                    <a href="{{ asset($leave_report->attachment) }}" download>
                                        <br>
                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                            width="15" height="15" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512"
                                            xml:space="preserve" class="">
                                            <g>
                                                <path
                                                    d="M128 65c0 15.439-12.563 28-28 28H80c-2.211 0-4-1.791-4-4s1.789-4 4-4h20c11.027 0 20-8.973 20-20s-8.973-20-20-20h-4c-2.211 0-4-1.791-4-4 0-15.439-12.563-28-28-28S36 25.561 36 41c0 2.209-1.789 4-4 4h-4C16.973 45 8 53.973 8 65s8.973 20 20 20h20c2.211 0 4 1.791 4 4s-1.789 4-4 4H28C12.563 93 0 80.439 0 65s12.563-28 28-28h.223C30.219 19.025 45.5 5 64 5s33.781 14.025 35.777 32H100c15.438 0 28 12.561 28 28zm-50.828 37.172L68 111.344V61c0-2.209-1.789-4-4-4s-4 1.791-4 4v50.344l-9.172-9.172c-1.563-1.563-4.094-1.563-5.656 0s-1.563 4.094 0 5.656l16 16c.781.781 1.805 1.172 2.828 1.172s2.047-.391 2.828-1.172l16-16c1.563-1.563 1.563-4.094 0-5.656s-4.094-1.563-5.656 0z"
                                                    fill="#000000" data-original="#000000" class=""></path>
                                            </g>
                                        </svg>
                                        {{ get_phrase('Download') }}
                                    </a>
                                @endif
                            </td>
                            <td class="w-80px">
                                @if ($leave_report->status == 'pending')
                                    <span class="badge bg-danger">{{get_phrase('Pending')}}</span>
                                @elseif($leave_report->status == 'rejected')
                                    <span class="badge bg-secondary">{{get_phrase('Rejected')}}</span>
                                @else
                                    <span class="badge bg-success">{{get_phrase('Approved')}}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>
