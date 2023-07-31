<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application};
use Session;

class StaffController extends Controller
{
    function __construct(){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
    
    function dashboard(){
    	return view('staff.dashboard');
    }

    function timesheet(){
    	return view('staff.timesheet');
    }

    function add_working_log(Request $request){
    	$this->validate($request,[
			'description'=>'required'
		]);

    	$from_date = strtotime($request->from_date);
    	$to_date = strtotime($request->to_date);

    	$data['user_id'] = auth()->user()->id;
    	$data['from_date'] = $from_date;
    	$data['to_date'] = $to_date;
    	$data['description'] = $request->description;
    	$data['working_time'] = $to_date - $from_date;

    	if($data['working_time'] <= 0){
            return redirect()->back()->withInput()->with('error_message', "From time and to time can't be same");
        }

//     	//check time duplication
//     	$query = Timesheet::where('user_id', $data['user_id'])->where('from_date', '<=', $from_date)->where('to_date', '>=', $from_date);
// 		$query->orWhere(function($query) use ($to_date){
//              $query->where('from_date', '<=', $to_date)->where('to_date', '>=', $to_date);
//         });

// 		if($query->get()->count() > 0){
//     		return redirect()->back()->withInput()->with('error_message', 'Multiple entries cannot be added at the same time');
// 		}

		$response = Timesheet::insert($data);
		return redirect()->back()->with('success_message', __('New working log has been added'));
    }


    //attendance
    function attendance(){
        return view('staff.attendance');
    }

    function attendance_add(Request $request){

        $current_timestamp = date('d M Y H:i:s');

        $start_timestamp_of_selected_date = strtotime(date('d M Y', strtotime($current_timestamp)));
        $end_timestamp_of_selected_date = strtotime(date('d M Y 23:59:59', strtotime($current_timestamp)));
        
        if(!empty($request->note)){
            $data['note'] = $request->note;
        }

        if($request->check_in_out == 'checkin'){

            if(date('H', strtotime($current_timestamp)) == 10 && date('i', strtotime($current_timestamp)) > 30){
                $data['late_entry'] = 1;
            }elseif(date('H', strtotime($current_timestamp)) > 10){
                $data['late_entry'] = 1;
            }

            $data['working_time'] = 0;

            $data['user_id'] = auth()->user()->id;
            $data['checkin'] = strtotime($current_timestamp);

            //check duplication
            $number_of_entry = Attendance::where('user_id', auth()->user()->id)->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date)->get()->count();
            if($number_of_entry > 0){
                return redirect()->back()->withInput()->with('error_message', __('You have already given entry today'));
            }

            Attendance::insert($data);
            return redirect()->back()->with('success_message', __('Attendance has been added'));
        }else{

            //check duplication
            $number_of_entry = Attendance::where('user_id', auth()->user()->id)->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date)->where('checkout', '!=', null)->get()->count();
            if($number_of_entry > 0){
                return redirect()->back()->withInput()->with('error_message', __('You have already given leaves entry today'));
            }

            $query = Attendance::where('user_id', auth()->user()->id)->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date);

            if($current_timestamp != null && date('G', strtotime($current_timestamp) - $query->value('checkin')) < 8){
                $data['early_leave'] = 1;
            }

            $data['working_time'] = (strtotime($current_timestamp) - $query->value('checkin')) + 1;
            $data['checkout'] = strtotime($current_timestamp);

            $query->update($data);
            return redirect()->back()->with('success_message', __('Attendance has been updated'));
        }
        

        $response = Timesheet::insert($data);
        return redirect()->back()->with('success_message', __('New working log has been added'));
    }

    function leave_application_add(Request $request){
        $data['user_id'] = auth()->user()->id;
        $data['status'] = 'pending';
        $data['from_date'] = strtotime($request->from_date);
        $data['to_date'] = strtotime($request->to_date);


        $start_timestamp = strtotime(date('d M Y', $data['from_date']));
        $end_timestamp = strtotime(date('d M Y 23:59:59', $data['to_date']));

        if($start_timestamp > $end_timestamp){
            return redirect()->back()->withInput()->with('error_message', __('Please select correct date range'));
        }

        $data['working_day'] = (($end_timestamp - $start_timestamp) + 1) / 86400;
        $data['reason'] = $request->reason;

        Leave_application::insert($data);

        return redirect()->back()->with('success_message', __('Your request has been successfully submitted'));
    }

    function assessment(){
        return view('staff.assessment');
    }
}