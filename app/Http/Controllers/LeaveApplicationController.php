<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

class LeaveApplicationController extends Controller
{

    function index($tasks_type = "archive"){
        $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        $page_data['tasks_type'] = $tasks_type;

        return view('admin.tasks.index', $page_data);
    }

    function store($user_id, Request $request){
        $this->validate($request,[
            'description'=>'required',
        ]);

        if($user_id){
            $data['user_id'] = $user_id;
        }else{
            $data['user_id'] = auth()->user()->id;
        }
        $data['description'] = $request->description;
        $data['is_completed'] = 0;
        $data['status'] = 'running';

        $id = Task::insertGetId($data);
        $page_data['task'] = Task::find($id);
        
        $response['prepend'] = ['elem' => '#user-task-list'.$user_id, 'content' => view('admin.tasks.task', $page_data)->render()];
        return json_encode($response);
    }

}
