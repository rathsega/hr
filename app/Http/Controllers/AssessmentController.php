<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    function __construct(){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
    
    function team_report($id = 0){
        if($id > 0){
            $page_data['staff'] = User::find($id);
            return view('admin.assessment.report_details', $page_data);
        }else{
            $page_data['active_staffs'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
            $page_data['inactive_staffs'] = User::where('role', '!=', 'admin')->where('status', 'inactive')->orderBy('sort', 'asc')->get();
            return view('admin.assessment.team_report', $page_data);
        }
    }

    function daily_report(){
        return view('admin.assessment.daily_report');
    }



    function assessment(){
        $page_data['users'] = User::orderBy('id', 'asc')->get();
        return view('admin.assessment', $page_data);
    }

    function assessment_add(Request $request){
        $this->validate($request,[
            'user_id'=>'required',
            'date_time'=>'required',
            'description' => 'required'
        ]);


        $data['user_id'] = $request->user_id;
        $data['date_time'] = strtotime($request->date_time);
        $data['description'] = $request->description;

        Assessment::insert($data);
        return redirect()->back()->with('success_message', __('Assessment added successfully'));
    }


    function assessment_rating_update($user_id, Request $request){


        if(isset($request->date_time) && $request->date_time != ''){
            $selected_timestamp_of_month = strtotime(date('1 M Y', strtotime($request->date_time)));
        }else{
            $selected_timestamp_of_month = strtotime(date('1 M Y'));
        }

        $start_date = date('Y-m-1 H:i:s', strtotime($request->date_time));
        $end_day = date('t', strtotime($request->date_time));
        $end_date = date('Y-m-'.$end_day.' H:i:s', strtotime($request->date_time));

        $data['user_id'] = $user_id;
        $data['type'] = $request->type;
        $data['date_time'] = strtotime($request->date_time);
        $data['created_at'] = date('Y-m-d H:i:s', strtotime($request->date_time));
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime($request->date_time));
        
        $query = Staff_performance::where('user_id', $user_id)->where('type', $request->type)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        if($request->type == 'remarks'){
            $data['description'] = $request->description;
        }else{
            $data['rating'] = $request->rating;
        }

        
        if($query->get()->count() > 0){
            Staff_performance::where('id', $query->first()->id)->update($data);
        }else{
            Staff_performance::insert($data);
        }
        return redirect(route('admin.assessment.team.report', ['id' => $user_id, 'tab' => 'performance']))->with('success_message', __('Assessment rating updated successfully'));
    }


    function incident_store(Request $request){
        $this->validate($request,[
            'user_id'=>'required',
            'date_time'=>'required',
            'description' => 'required'
        ]);


        $data['user_id'] = $request->user_id;
        $data['date_time'] = strtotime($request->date_time);
        $data['description'] = $request->description;
        print_r($data);
        die;
        Assessment::insert($data);
        return redirect(route('admin.assessment.daily.report'))->with('success_message', __('Assessment added successfully'));
    }




}
