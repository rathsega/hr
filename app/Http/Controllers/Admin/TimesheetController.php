<?php

namespace App\Http\Controllers\Admin;
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


        $data['user_id'] = $request->user_id;
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
            'user_id' => 'required',
            'lat'=>'required',
            'lon'=>'required',
        ]);

        if(auth()->user()->role == 'admin'){
            $data['user_id'] = $request->user_id;
        }

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['description'] = $request->description;
        $data['working_time'] = $to_date - $from_date;

        if($data['working_time'] <= 0){
            return redirect()->back()->withInput()->with('error_message', "From & To can't be same");
        }

        if(auth()->user()->role == 'admin'){
            Timesheet::where('id', $id)->update($data);
        }else{
            Timesheet::where('id', $id)->where('user_id', auth()->user()->id)->update($data);
        }
        return redirect(route('admin.timesheet'))->with('success_message', __('Timesheet has been updated'));
    }

    function delete($id = "", Request $request){
        if(auth()->user()->role == 'admin'){
            Timesheet::where('id', $id)->delete();
        }else{
            Timesheet::where('id', $id)->where('user_id', auth()->user()->id)->delete();
        }
        
        return redirect()->back()->with('success_message', get_phrase('Timesheet deleted successfully'));
    }

    
    function change_status($id, Request $request){

        $timesheet_report = Timesheet::where('id', $id)->first();
        $to = User::where('id', $timesheet_report->user_id)->first();

        if($request->status == 'hr_approved'){
            $data['status'] = 'hr_approved';
        }elseif($request->status == 'manager_approved'){
            $data['status'] = 'manager_approved';
        }elseif($request->status == 'manager_rejected'){
            $data['status'] = 'manager_rejected';
        }elseif($request->status == 'hr_rejected'){
            $data['status'] = 'hr_rejected';
        }elseif($request->status == 'pending'){
            $data['status'] = 'pending';
        }

        if($request->message){
            $data['message'] = $request->message;
        }

        Timesheet::where('id', $id)->update($data);
        
        return redirect()->back()->with('success_message', get_phrase('Status has been updated'));
    }
    
    
}