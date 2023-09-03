<div style="margin-left: auto; margin-right: auto; border: 1px solid #cdcdcd; max-width: 700px; padding: 30px 10px;">
    @php
        $user = App\Models\User::where('id', $user_id)->first();
        $payslip = App\Models\Payslip::where('id', $invoice_id)->first();
    @endphp
    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="text-align: center">
                <img src="{{ asset('public/assets/images/favicon.png') }}" alt="" style="width: 37px;" />
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

    <table style="width: 100%; margin-top: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <h3 style="margin-bottom: 20px;"><u>Paid By</u></h3>
                <h3 style="margin: 0px;">Joyonta Roy</h3>
                <p style="margin: 0px;">CEO</p>
                <p style="margin: 0px;">Creativeitem</p>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="margin-bottom: 20px;"><u>Paid To</u></h3>
                <h3 style="margin: 0px;">{{ $user->name }}</h3>
                <p style="margin: 0px;">{{ $user->designation }}</p>
                <p style="margin: 0px;">Creativeitem</p>
            </td>
        </tr>
    </table>
</div>
