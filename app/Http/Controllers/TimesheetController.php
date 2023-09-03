<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

class TimesheetController extends Controller
{
    function index(){
        $page_data['users'] = User::where('status', 'active')->orderBy('id', 'asc')->get();
        return view(auth()->user()->role.'.timesheet.index', $page_data);
    }

    function store(Request $request){
        $this->validate($request,[
            'description'=>'required',
            'user_id' => 'required',
            'lat'=>'required',
            'lon'=>'required',
        ]);

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $data['location'] = getCurrentLocation($request->lat, $request->lon);

        $data['user_id'] = $request->user_id;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['description'] = $request->description;
        $data['working_time'] = $to_date - $from_date;


        if($data['working_time'] <= 0){
            return redirect()->back()->withInput()->with('error_message', "From & To can't be same");
        }

        

        $id = Timesheet::insertGetId($data);

        session(['table' => 'timesheets', 'location' => base64_encode($data['location']), 'id' => $id]);
        return redirect()->back()->with('success_message', __('New working log has been added'));
    }
    
}