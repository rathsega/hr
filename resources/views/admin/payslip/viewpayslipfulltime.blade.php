@extends('index')
@push('title', get_phrase('Payslip'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Payslip') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="{{ route('admin.payslip') }}">{{ get_phrase('Payslip') }}</a></li>
                <li><a href="{{ route('admin.payslip') }}">{{ $payslip[0]->name }}</a></li>
            </ul>
        </div>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"  type="text/html"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet"  type="text/html"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js">
    <link rel="stylesheet"  type="text/html"  href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <style>
        *{
          font-size: 13px;
        }
        .z-img{
            height: 65px;
            /* display:flex;
            float: right; */
        }
        table {
            border-collapse: collapse !important;
        }
        .justify-content-center {
            justify-content: center!important;
        }
    </style>
</head>
<body style="border:2px solid rgb(7, 7, 7);">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="text-center lh-1 mb-2">
                    
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('assets/images/zettamine-logo.png')))}}" alt="" class="z-img">
                    <h6 class="fw-bold">Payslip</h6> 
                </div>
       
                <div class="row">
                    <div class="col-md-12">
                        <table class="mt-4 table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" >Employee ID</th>
                                    <td>{{$payslip[0]->emp_id}}</td>
                                    <td><b> Employee Name</b></td>
                                    <td>{{$payslip[0]->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Designation</th>
                                    <td>{{$payslip[0]->designation}}</td>
                                    <td><b> Month/Year</b></td>
                                    <td>{{$payslip[0]->payroll_month}}/{{$payslip[0]->payroll_year}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Department </th>
                                    <td>{{$payslip[0]->title}}</td>
                                    <td><b> UAN Number</b></td>
                                    <td>{{$payslip[0]->uan_number}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Bank Account No</th>
                                    <td>{{$payslip[0]->bank_account_number}} </td>
                                    <td><b>No of Working days</b></td>
                                    <td>{{$payslip[0]->workingdays}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">PF Number</th>
                                    <td>{{$payslip[0]->pf_number}} </td>
                                    <td><b>Date of Joining </b></td>
                                    <td>{{$payslip[0]->joining_date}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="mt-4 table table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th scope="col">Earnings</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Deductions</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Basic</th>
                                <td>{{$payslip[0]->basic}}</td>
                                <td><b>Provident Fund</b></td>
                                <td>{{$payslip[0]->pf}}</td>
                            </tr>
                            <tr>
                                <th scope="row">HRA</th>
                                <td>{{$payslip[0]->hra}}</td>
                                <td><b>ESI</b></td>
                                <td>{{$payslip[0]->employee_esi + $payslip[0]->employer_esi}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Conveyance</th>
                                <td>{{$payslip[0]->conveyance}} </td>
                                <td><b> Professional Tax </b></td>
                                <td>{{$payslip[0]->pt}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Medical </th>
                                <td>{{$payslip[0]->medical}}</td>
                                <td><b>Income Tax</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">LTA</th>
                                <td>{{$payslip[0]->lta}} </td>
                                <td><b>Salary advance</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Educational Allowances </th>
                                <td>{{$payslip[0]->education_allowance}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Special Allowances</th>
                                <td>{{$payslip[0]->special_allowance}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">Total </th>
                                <td>{{$payslip[0]->total_earnings}}</td>
                                <td><b>Total</b></td>
                                <td>{{$payslip[0]->deductions}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
    
                    <table class="mt-4 table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Total </th>
                                <td><b>{{$payslip[0]->total_earnings - $payslip[0]->deductions}} </b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h6 class="fw-bold text-center">This is computer generated Payslip signature not required.</h6> </span>
            </div>
        </div>
    </div>
</body>
</html>
@endsection