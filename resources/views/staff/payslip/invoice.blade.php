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
                <h3>{{get_phrase('Payslip')}}</h3>
            </td>
        </tr>
    </table>

    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 50%; text-align: right;">{{get_phrase('Name')}}</td>
            <td style="width: 1px;">:</td>
            <td style="width: 50%; text-align: left">{{ $user->name }}</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: right;">{{get_phrase('Designation')}}</td>
            <td style="width: 1px;">:</td>
            <td style="width: 50%; text-align: left">{{ $user->designation }}</td>
        </tr>
    </table>

    <table style="width: 100%; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td>
                <h3 style="text-align: center;">{{get_phrase('Brief of monthly salary')}} ({{ date('1 M - t M, Y', strtotime($payslip->month_of_salary)) }})</h3>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; max-width: 600px; margin-left: auto; margin-right: auto;">
        <thead>
            <th style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{get_phrase('Subject')}}</th>
            <th style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{get_phrase('Amount')}}</th>
        </thead>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{get_phrase('Net Salary')}}</td>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{ $payslip->net_salary }} /=</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{get_phrase('Bonus')}}</td>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{ $payslip->bonus }} /=</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{get_phrase('Penalty deductions')}}</td>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;">{{ $payslip->penalty }} /=</td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;"><b>{{get_phrase('Net salary payable')}}</b></td>
            @php
                $total_payable_amount = $payslip->net_salary + $payslip->bonus - $payslip->penalty;
            @endphp
            <td style="width: 50%; text-align: left; border: 1px solid; padding: 5px;"><b>{{ $total_payable_amount }} /=</b></td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 50%; text-align: left;">
                <h3 style="margin-bottom: 20px;"><u>{{get_phrase('Paid By')}}</u></h3>
                <h3 style="margin: 0px;">{{App\Models\User::where('role', 'admin')->first()->name}}</h3>
                <p style="margin: 0px;">{{App\Models\User::where('role', 'admin')->first()->role}}</p>
                <p style="margin: 0px;">{{get_settings('system_name')}}</p>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="margin-bottom: 20px;"><u>{{get_phrase('Paid To')}}</u></h3>
                <h3 style="margin: 0px;">{{ $user->name }}</h3>
                <p style="margin: 0px;">{{ $user->designation }}</p>
                <p style="margin: 0px;">{{get_settings('system_name')}}</p>
            </td>
        </tr>
    </table>
</div>
