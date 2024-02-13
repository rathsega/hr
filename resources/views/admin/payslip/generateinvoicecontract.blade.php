<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payslip</title>

</head>
<style>
    p {
        font-size: 12px;
        font-weight: 500;
    }

    table {
        width: 100%;
        border-collapse: collapse !important;
        border: 1px solid black;
    }

    .para {
        font-size: 14px;
        font-weight: 100;
    }

    .z-img {}

    table tr,td,th {
        line-height: 25px;
        padding-left: 15px;
        border-width: 1px !important;
    }

    .payslip-body{
        font-style: normal;
        width: 65vw;
        margin-left:17%;
        font-size: 12px;font-family:Poppins, sans-serif; 
    }

        .justify-content-center {
            justify-content: center !important;
        }

    /* table th{background-color:#fbc403; color:#363636;} */
</style>

<body >
    @php
    function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred','thousand','lakh', 'crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '');
    }



    @endphp

    <table border="1">
        <tr height="100px" style="color:#363636;text-align:center;font-size:24px; font-weight:600;">
            <td colspan='6'> <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('assets/images/zettamine-logo.png')))}}" alt="" style=" height:50px;display:flex;float: left;margin-top: -11px;">
                <div style="margin-right: 145px"> <span>ZettaMine Labs Pvt Limited</span> <br>
                    <p class="para" style="margin-left: 145px;">Plot No - 85 ,Kundanbagh, Methodist Colony , Begumpet, Hyderbad -500016</p>
                </div>
            </td>
        </tr>
        <tr style="color:#363636;text-align:center;font-size:24px; font-weight:200;">
            <td colspan='6'>
                <p class="para">Pay Advice for {{date("F", strtotime("01-".$payslip[0]->payroll_month."-".$payslip[0]->payroll_year))}} {{$payslip[0]->payroll_year}} </p>
            </td>
        </tr>
        <tr height="100px" style="color:#363636;font-size:24px; font-weight:600;">
            <td colspan='3' style="text-align: start;">
                <p><b>Employee Pay Summary</b> </p>
                <p>Employee Name : {{$payslip[0]->name}}</p>
                <p>Designation &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; : {{$payslip[0]->designation}}</p>
                <p>Date of Joining &nbsp; &nbsp;: {{date('d-m-Y', strtotime($payslip[0]->joining_date))}}</p>
                <p>Pay Period &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : 1-{{date("M", strtotime("01-".$payslip[0]->payroll_month."-".$payslip[0]->payroll_year))}}-{{$payslip[0]->payroll_year}} to {{$payslip[0]->workingdays}} -{{date("M", strtotime("01-".$payslip[0]->payroll_month."-".$payslip[0]->payroll_year))}}-{{$payslip[0]->payroll_year}}</p>
                <p>Pay Date &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : 05-Sep-2023</p>
            </td>
            <td>
                <p class="para">Contract Employee Net Pay</p>
                <p><b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->net_salary}}</b></p>
                <p>Paid Days: {{$payslip[0]->workingdays - $payslip[0]->loss_of_pay}} | LOP Days: {{$payslip[0]->loss_of_pay}}</p>
            </td>

        </tr>
        <tr>
            <th>EARNINGS</th>
            <th>AMOUNT</th>
            <td>-------</td>
            <th>DEDUCTIONS</th>
            <th>AMOUNT</th>
            <td>--------</td>
        </tr>
        <!-----2 row--->
        <tr style="text-align: center;">
            <td>Gross Earnings</td>
            <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->payable_amount}}</td>
            <td></td>
            <td>TDS</td>
            <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->tds}}</td>
            <td></td>
        </tr>
        <!------3 row---->
        <tr>
            <td> &nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <!------4 row---->
        <tr>
            <td> &nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <!------5 row---->
        <tr style="text-align: center;">
            <td><b>Total Gross Earnings</b></td>
            <td><b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->payable_amount}}</b></td>
            <td></td>
            <td><b>Total Deductions</b> </td>
            <td><b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->tds}}</b></td>
            <td></td>
        </tr>
        <!------6 row---->
        <tr>
            <td> &nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td> &nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td> &nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br />
    <table border="1">
        <tr>
            <td style="text-align: left;"><b>NETPAY</b></td>
            <td style="text-align: right;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->net_salary}}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Gross Earnings</td>
            <td style="text-align: right;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->payable_amount}}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Total Deductions</td>
            <td style="text-align: right;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->tds}}</td>
        </tr>
        <tr>
            <td style="text-align:right;">Total Net Payable </td>
            <td style="text-align: right;"><b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{$payslip[0]->net_salary}}</b> </td>
        </tr>
        <tr>
            <table>
                <tr><th>Total Net Payable : {{getIndianCurrency($payslip[0]->net_salary .'.00')}}</th></tr>
            </table>
        </tr>
    </table>
</body>

</html>