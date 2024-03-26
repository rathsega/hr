<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

use Jenssegers\Agent\Agent;

class TimesheetController extends Controller
{
    function index(){
        return view('staff.timesheet.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'description'=>'required',
            'lat'=>'required',
            'lon'=>'required',
        ]);

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        //Location tracking
        $data['location'] = getCurrentLocation($request->lat, $request->lon);


        //Device tracking
        $agent = new Agent();
        if($agent->isMobile()){
            $device = "Submitted from Mobile (".$agent->browser().")";
        }elseif($agent->isTablet()){
            $device = "Submitted from Tablet (".$agent->browser().")";
        }else{
            $device = "Submitted from ".$agent->platform()." (".$agent->browser().")";
        }
        $data['device'] = $device;

        $data['status'] = "pending";


        $data['user_id'] = auth()->user()->id;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['description'] = $request->description;
        $data['working_time'] = $to_date - $from_date;


        if($data['working_time'] <= 0){
            return redirect()->back()->withInput()->with('error_message', "From & To can't be same");
        }

        $id = Timesheet::insertGetId($data);

        return redirect()->back()->with('success_message', __('New working log has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'description'=>'required',
            'lat'=>'required',
            'lon'=>'required',
        ]);

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['description'] = $request->description;
        $data['working_time'] = $to_date - $from_date;

        if($data['working_time'] <= 0){
            return redirect()->back()->withInput()->with('error_message', "From & To can't be same");
        }

        
        Timesheet::where('id', $id)->where('user_id', auth()->user()->id)->update($data);
        return redirect(route('staff.timesheet'))->with('success_message', __('Timesheet has been updated'));
    }

    function delete($id = "", Request $request){
        Timesheet::where('id', $id)->where('user_id', auth()->user()->id)->delete();
        return redirect()->back()->with('success_message', get_phrase('Timesheet deleted successfully'));
    }
    
}