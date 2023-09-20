<div style="margin-left: auto; margin-right: auto; border: 1px solid #cdcdcd; max-width: 700px; padding: 35px 30px;">
    @php
        $user = App\Models\User::where('id', $user_id)->first();
        $payslip = App\Models\Payslip::where('id', $invoice_id)->first();
    @endphp
    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="text-align: center">
                <img src="{{ url('public/assets/images/favicon.png') }}" alt="" style="width: 37px;" />
            </td>
        </tr>
    </table>

    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="text-align: center">
                <h3>Payslip</h3>
            </td>
        </tr>
    </table>

    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 50%; text-align: right;">Name</td>
            <td style="width: 1px;">:</td>
            <td style="width: 50%; text-align: left">{{ $user->name }}</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: right;">Designation</td>
            <td style="width: 1px;">:</td>
            <td style="width: 50%; text-align: left">{{ $user->designation }}</td>
        </tr>
    </table>

    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td>
                <h3 style="text-align: center;">Brief of monthly salary ({{ date('1 M - t M, Y', strtotime($payslip->month_of_salary)) }})</h3>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; max-width: 600px; margin-left: auto; margin-right: auto;">
        <thead>
            <th style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">Subject</th>
            <th style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">Amount</th>
        </thead>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">Net Salary</td>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{ $payslip->net_salary }} /=</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">Bonus</td>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{ $payslip->bonus }} /=</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">Penalty deductions</td>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{ $payslip->penalty }} /=</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;"><b>Net salary payable</b></td>
            @php
                $total_payable_amount = $payslip->net_salary + $payslip->bonus - $payslip->penalty;
            @endphp
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;"><b>{{ $total_payable_amount }} /=</b></td>
        </tr>
    </table>







    {{-- Performance rating --}}
    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto; margin-top: 40px;">
        <tr>
            <td>
                <h3 style="text-align: center;">Monthly performance rating summary</h3>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; max-width: 600px; margin-left: auto; margin-right: auto;">
        @php
            $start_date = date('Y-m-1 00:00:00', strtotime($payslip->month_of_salary));
            $end_date = date('Y-m-t 23:59:59', strtotime($payslip->month_of_salary));
            $performance_review = App\Models\Performance::whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->where('user_id', $payslip->user_id)
                ->first();
            if ($performance_review) {
                $remarks = $performance_review->remarks;
                $ratings = json_decode($performance_review->ratings, true);
            } else {
                $remarks = '';
                $ratings = [];
            }
        @endphp
        @foreach (App\Models\Performance_type::get() as $performance_type)
            <tr>
                <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">
                    <span>{{ $performance_type->title }}:</span>
                </td>
                <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">
                    @for ($i = 1; $i <= 5; $i++)
                        @if (count($ratings) > 0 && array_key_exists($performance_type->slug, $ratings) && $i <= $ratings[$performance_type->slug])
                            <span style="color: #fccb4c !important;">&#9733;</span>
                        @elseif(count($ratings) > 0 && array_key_exists($performance_type->slug, $ratings))
                            <span>&#9733;</span>
                        @else
                            <span>&#9734;</span>
                        @endif
                    @endfor
                </td>
            </tr>
        @endforeach
        @if ($remarks != '')
            <tr>
                <td colspan="2" style="text-align: left; border: 1px solid; padding: 5px;">
                    <p><b>Remarks:</b></p>
                    {!! script_checker($remarks) !!}
                </td>
            </tr>
        @endif

        @php
            $assessments = App\Models\Assessment::where('user_id', $payslip->user_id)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
        @endphp
        @if ($assessments->count() > 0)
            <tr>
                <td colspan="2" style="text-align: left; border: 1px solid; padding: 5px;">
                    <p><b>Assessments:</b></p>
                    <ul>

                        @foreach ($assessments as $assessment)
                            <li>{{ $assessment->description }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endif
    </table>
    {{-- Performance rating --}}






    <table style="width: 100%; margin-top: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <h3 style="margin-bottom: 20px;"><u>Paid By</u></h3>
                <h3 style="margin: 0px;">{{App\Models\User::where('role', 'admin')->first()->name}}</h3>
                <p style="margin: 0px;">{{App\Models\User::where('role', 'admin')->first()->role}}</p>
                <p style="margin: 0px;">{{get_settings('system_name')}}</p>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="margin-bottom: 20px;"><u>Paid To</u></h3>
                <h3 style="margin: 0px;">{{ $user->name }}</h3>
                <p style="margin: 0px;">{{ $user->designation }}</p>
                <p style="margin: 0px;">{{get_settings('system_name')}}</p>
            </td>
        </tr>
    </table>
</div>
