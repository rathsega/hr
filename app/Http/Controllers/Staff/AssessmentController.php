<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

class AssessmentController extends Controller
{

    function index(){
        return view(auth()->user()->role.'.assessment.index');
    }
}
