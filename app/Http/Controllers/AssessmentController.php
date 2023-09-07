<?php

namespace App\Http\Controllers;

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

    function store(Request $request){
        if(auth()->user()->role == 'admin'){
            $data['user_id'] = $request->user_id;
        }elseif(auth()->user()->role == 'staff'){
            $data['user_id'] = auth()->user()->id;
        }

        $this->validate($request,[
            'user_id'=>'required',
            'date_time'=>'required',
            'description' => 'required'
        ]);


        $data['date_time'] = strtotime($request->date_time);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['description'] = $request->description;

        Assessment::insert($data);
        return redirect(route('admin.assessment'))->with('success_message', __('Assessment added successfully'));
    }

    function update($id = "", Request $request){
        if(auth()->user()->role == 'admin'){
            $data['user_id'] = $request->user_id;
            $query = Assessment::where('id', $id);
        }else{
            $query = Assessment::where('id', $id)->where('user_id', auth()->user()->id);
        }

        $this->validate($request,[
            'user_id'=>'required',
            'date_time'=>'required',
            'description' => 'required'
        ]);

        $data['date_time'] = strtotime($request->date_time);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['description'] = $request->description;

        $query->update($data);
        return redirect(route('admin.assessment'))->with('success_message', __('Assessment updated successfully'));
    }

    function delete($id = ""){
        if(auth()->user()->role == 'admin'){
            $query = Assessment::where('id', $id);
        }else{
            $query = Assessment::where('id', $id)->where('user_id', auth()->user()->id);
        }

        $query->delete();
        return redirect(route('admin.assessment'))->with('success_message', __('Assessment deleted successfully'));
    }
    


























    // function team_report($id = 0){
    //     if($id > 0){
    //         $page_data['staff'] = User::find($id);
    //         return view('admin.assessment.report_details', $page_data);
    //     }else{
    //         $page_data['active_staffs'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
    //         $page_data['inactive_staffs'] = User::where('role', '!=', 'admin')->where('status', 'inactive')->orderBy('sort', 'asc')->get();
    //         return view('admin.assessment.team_report', $page_data);
    //     }
    // }

    // function daily_report(){
    //     return view('admin.assessment.daily_report');
    // }



    // function assessment(){
    //     $page_data['users'] = User::orderBy('id', 'asc')->get();
    //     return view('admin.assessment', $page_data);
    // }

    // function assessment_add(Request $request){
    //     $this->validate($request,[
    //         'user_id'=>'required',
    //         'date_time'=>'required',
    //         'description' => 'required'
    //     ]);


    //     $data['user_id'] = $request->user_id;
    //     $data['date_time'] = strtotime($request->date_time);
    //     $data['description'] = $request->description;

    //     Assessment::insert($data);
    //     return redirect()->back()->with('success_message', __('Assessment added successfully'));
    // }


    // function assessment_rating_update($user_id, Request $request){

    //     $start_date = date('Y-m-1 H:i:s', strtotime($request->date_time));
    //     $end_day = date('t', strtotime($request->date_time));
    //     $end_date = date('Y-m-'.$end_day.' H:i:s', strtotime($request->date_time));

    //     $data['user_id'] = $user_id;
    //     $data['date_time'] = strtotime($request->date_time);
    //     $data['created_at'] = date('Y-m-d H:i:s', strtotime($request->date_time));
    //     $data['updated_at'] = date('Y-m-d H:i:s', strtotime($request->date_time));

    //     foreach($request->rating as $type => $rating_value){
    //         $query = Staff_performance::where('user_id', $user_id)->where('type', $type)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
    //         $data['type'] = $type;
    //         if($type == 'remarks'){
    //             $data['description'] = $request->description;
    //         }else{
    //             $data['rating'] = $rating_value;
    //         }
            
    //         if($query->get()->count() > 0){
    //             Staff_performance::where('user_id', $user_id)->where('type', $type)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->update($data);
    //         }else{
    //             Staff_performance::insert($data);
    //         }
    //     }
        
    //     return redirect(route('admin.assessment.team.report', ['id' => $user_id, 'tab' => 'performance']))->with('success_message', __('Assessment rating updated successfully'));
    // }


    // function incident_store(Request $request){
    //     $this->validate($request,[
    //         'user_id'=>'required',
    //         'date_time'=>'required',
    //         'description' => 'required'
    //     ]);


    //     $data['user_id'] = $request->user_id;
    //     $data['date_time'] = strtotime($request->date_time);
    //     $data['description'] = $request->description;
    //     Assessment::insert($data);
    //     return redirect(route('admin.assessment.daily.report'))->with('success_message', __('Assessment added successfully'));
    // }




}
