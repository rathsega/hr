<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance, Payslip, Performance_type, Performance};
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    function index(){
        $page_data['user'] = User::where('id', auth()->user()->id)->first();
        $page_data['performance_types'] = Performance_type::get();
        return view(auth()->user()->role.'.performance.index', $page_data);
    }
}
