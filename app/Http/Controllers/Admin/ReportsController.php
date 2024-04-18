<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{EmployeeOfTheMonth, User};

class ReportsController extends Controller
{
    function attendance()
    {
        $page_data['title'] = "Attendance Report";
        return view(auth()->user()->role . '.reports.attendance', $page_data);
    }

    function latelogin()
    {
        $page_data['title'] = "Late Login Report";
        return view(auth()->user()->role . '.reports.latelogin', $page_data);
    }

    function joining(){
        $page_data['title'] = "Joinings Report";
        return view(auth()->user()->role . '.reports.joining', $page_data);
    }

    function exit(){
        $page_data['title'] = "Exits Report";
        return view(auth()->user()->role . '.reports.exit', $page_data);
    }

    function leavebalance(){
        $page_data['title'] = "Leave Balance Report";
        return view(auth()->user()->role . '.reports.leavebalance', $page_data);
    }

    function payroll(){
        $page_data['title'] = "Payroll Report";
        return view(auth()->user()->role . '.reports.payroll', $page_data);
    }

    

    
}
