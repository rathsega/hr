<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

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

        $start_timestamp_of_selected_date = strtotime(date('d M Y', strtotime($request->time)));
        $end_timestamp_of_selected_date = strtotime(date('d M Y 23:59:59', strtotime($request->time)));
        
        if(!empty($request->note)){
            $data['note'] = $request->note;
        }


        if($request->check_in_out == 'checkin'){
            if(auth()->user()->role == 'admin'){
                $query = Attendance::where('user_id', $request->user_id);
                $data['user_id'] = $request->user_id;
            }elseif(auth()->user()->role == 'staff'){
                $query = Attendance::where('user_id', auth()->user()->id);
                $data['user_id'] = auth()->user()->id;
            }

            $data['location'] = json_encode(['in' => getCurrentLocation($request->lat, $request->lon)]);
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

            $in_lat_lon = json_decode($query->value('location'), true);
            $in_lat_lon['out'] = getCurrentLocation($request->lat, $request->lon);
            $data['location'] = json_encode($in_lat_lon);

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

        $response = Timesheet::insert($data);
        return redirect()->back()->with('success_message', __('New working log has been added'));
    }
    
}