<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Illuminate\Support\Facades\DB;

use App\Exports\{AttendanceExport, LateLoginExport};
use Maatwebsite\Excel\Facades\Excel;

use Jenssegers\Agent\Agent;

class AttendanceController extends Controller
{
    function index(){
        if(auth()->user()->role == 'admin'){
            $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        }elseif(auth()->user()->role == 'staff'){
            $page_data['users'] = User::where('id', auth()->user()->id)->get();
        }

        return view(auth()->user()->role.'.attendance.index', $page_data);
    }

    function store(Request $request){
        $this->validate($request,[
            'lat'=>'required',
            'lon'=>'required',
        ]);

        $request->time = date("Y-m-d H:i:s");
        
        $start_timestamp_of_selected_date = strtotime(date('d M Y', strtotime($request->time)));
        $end_timestamp_of_selected_date = strtotime(date('d M Y 23:59:59', strtotime($request->time)));
        
        if(!empty($request->note)){
            $data['note'] = $request->note;
        }

        $data['status'] = "pending";
        if($request->check_in_out == 'checkin'){
            if(auth()->user()->role == 'admin'){
                $query = Attendance::where('user_id', $request->user_id);
                $data['user_id'] = $request->user_id;
            }elseif(auth()->user()->role == 'staff'){
                $query = Attendance::where('user_id', auth()->user()->id);
                $data['user_id'] = auth()->user()->id;
            }

            //Location tracking
            $data['location'] = json_encode(['in' => getCurrentLocation($request->lat, $request->lon)]);


            //Device tracking
            $agent = new Agent();
            if($agent->isMobile()){
                $device = "Submitted from Mobile (".$agent->browser().")";
            }elseif($agent->isTablet()){
                $device = "Submitted from Tablet (".$agent->browser().")";
            }else{
                $device = "Submitted from ".$agent->platform()." (".$agent->browser().")";
            }
            $data['device'] = json_encode(['in' => $device]);




            $data['working_time'] = 0;
            $data['checkin'] = strtotime($request->time);
            if(date('H', strtotime($request->time)) == 10 && date('i', strtotime($request->time)) > 30){
                $data['late_entry'] = 1;
            }elseif(date('H', strtotime($request->time)) > 10){
                $data['late_entry'] = 1;
            }

            $number_of_entry = $query->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date)->get()->count();
            if($number_of_entry > 0){
                return redirect()->back()->withInput()->with('error_message', __('There is already an entry for your selected date'));
            }

            $id = Attendance::insertGetId($data);

            session(['table' => 'attendances', 'location' => base64_encode($data['location']), 'id' => $id]);
            return redirect()->back()->with('success_message', __('Attendance has been added'));
        }else{
            if(auth()->user()->role == 'admin'){
                $query = Attendance::where('user_id', $request->user_id)->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date);
            }elseif(auth()->user()->role == 'staff'){
                $query = Attendance::where('user_id', auth()->user()->id)->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date);
            }

            //Location tracking
            $out_lat_lon = json_decode($query->value('location'), true);
            $out_lat_lon['out'] = getCurrentLocation($request->lat, $request->lon);
            $data['location'] = json_encode($out_lat_lon);


            //Device tracking
            $agent = new Agent();
            if($agent->isMobile()){
                $device = "Submitted from Mobile (".$agent->browser().")";
            }elseif($agent->isTablet()){
                $device = "Submitted from Tablet (".$agent->browser().")";
            }else{
                $device = "Submitted from ".$agent->platform()." (".$agent->browser().")";
            }
            $out_device = json_decode($query->value('device'), true);
            $out_device['out'] = $device;
            $data['device'] = json_encode($out_device);

            if($request->time != null && gmdate('H', strtotime($request->time) - $query->value('checkin')) < 8){
                $data['early_leave'] = 1;
            }else{
                $data['early_leave'] = null;
            }

            $data['working_time'] = (strtotime($request->time) - $query->value('checkin')) + 1;
            $data['checkout'] = strtotime($request->time);


            $query->update($data);

            session(['table' => 'attendances', 'location' => base64_encode($data['location']), 'id' => $query->value('id')]);
            return redirect()->back()->with('success_message', __('Attendance has been updated'));
        }
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'user_id'=>'required',
            'lat'=>'required',
            'lon'=>'required',
        ]);
        if(auth()->user()->role == 'admin'){
            $data['user_id'] = $request->user_id;
        }
        $data['note'] = $request->note;

        if($request->check_in_time){
            $data['working_time'] = 0;
            $data['checkin'] = strtotime($request->check_in_time);
            if(date('H', strtotime($request->check_in_time)) == 10 && date('i', strtotime($request->check_in_time)) > 30){
                $data['late_entry'] = 1;
            }elseif(date('H', strtotime($request->check_in_time)) > 10){
                $data['late_entry'] = 1;
            }else{
                $data['late_entry'] = null;
            }
            $data['checkin'] = strtotime($request->check_in_time);
        }

        if($request->check_out_time){
            if(gmdate('H', strtotime($request->check_out_time) - strtotime($request->check_in_time)) < 8){
                $data['early_leave'] = 1;
            }else{
                $data['early_leave'] = null;
            }

            $data['working_time'] = (strtotime($request->check_out_time) - strtotime($request->check_in_time)) + 1;
            $data['checkout'] = strtotime($request->check_out_time);
        }


        Attendance::where('id', $id)->update($data);
        return redirect(route('admin.attendance'))->with('success_message', __('Attendance has been updated'));
    }

    function delete($id = "", Request $request){
        if(auth()->user()->role == 'admin'){
            Attendance::where('id', $id)->delete();
        }else{
            Attendance::where('id', $id)->where('user_id', auth()->user()->id)->delete();
        }
        
        return redirect()->back()->with('success_message', get_phrase('Attendance deleted successfully'));
    }

    
    function change_status($id, Request $request){

        $attendance_report = Attendance::where('id', $id)->first();
        $to = User::where('id', $attendance_report->user_id)->first();

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

        Attendance::where('id', $id)->update($data);
        
        return redirect()->back()->with('success_message', get_phrase('Status has been updated'));
    }

    public function reports(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $start_timestamp = strtotime($request->from_date);
        $end_timestamp = strtotime($request->to_date);

        if($start_timestamp > $end_timestamp){
            return redirect()->back()->withInput()->with('error_message', get_phrase('Please select correct date range'));
        }

        return Excel::download(new AttendanceExport($from_date, $to_date), 'AttendanceReport.xlsx');
    }

    public function lateloginreports(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $start_timestamp = strtotime($request->from_date);
        $end_timestamp = strtotime($request->to_date);

        if($start_timestamp > $end_timestamp){
            return redirect()->back()->withInput()->with('error_message', get_phrase('Please select correct date range'));
        }

        return Excel::download(new LateLoginExport($from_date, $to_date), 'LateLoginsReport.xlsx');
    }
    
}