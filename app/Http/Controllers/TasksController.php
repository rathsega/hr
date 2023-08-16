<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

class TasksController extends Controller
{

    function index($tasks_type = "archive"){
        if(auth()->user()->role == 'admin'){
            $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        }elseif(auth()->user()->role == 'staff'){
            $page_data['users'] = User::where('id', auth()->user()->id)->get();
        }

        $page_data['tasks_type'] = $tasks_type;
        return view(auth()->user()->role.'.tasks.index', $page_data);
    }

    function store($user_id, Request $request){
        if(auth()->user()->role == 'admin'){
            $data['user_id'] = $user_id;
        }else{
            $data['user_id'] = auth()->user()->id;
        }


        $this->validate($request,[
            'description'=>'required',
        ]);
        $data['description'] = $request->description;
        $data['is_completed'] = 0;
        $data['status'] = 'running';

        $id = Task::insertGetId($data);
        $page_data['task'] = Task::find($id);
        
        $response['prepend'] = ['elem' => '#user-task-list'.$user_id, 'content' => view(auth()->user()->role.'.tasks.task', $page_data)->render()];
        return json_encode($response);
    }

    function update($id, Request $request){
        if(auth()->user()->role == 'admin'){
            $query = Task::where('id', $request->id);;
        }else{
            $query = Task::where('id', $request->id)->where('user_id', auth()->user()->id);
        }

        $this->validate($request,[
            'description'=>'required',
        ]);
        $data['description'] = $request->description;
        $query->update($data);
    }

    function task_completion(Request $request){
        if(auth()->user()->role == 'admin'){
            $query = Task::where('id', $request->id);;
        }else{
            $query = Task::where('id', $request->id)->where('user_id', auth()->user()->id);
        }

        if($query->value('is_completed') == 1){
            $query->update(['is_completed' => 0]);
            $response['removeClass'] = ['elem' => '#task-list'.$request->id, 'content' => 'completed'];
            $response['success'] = get_phrase('Marked as incompleted');
        }else{
            $query->update(['is_completed' => 1]);
            $response['addClass'] = ['elem' => '#task-list'.$request->id, 'content' => 'completed'];
            $response['success'] = get_phrase('Marked as completed');
        }

        return json_encode($response);
    }

    function task_status(Request $request){
        if(auth()->user()->role == 'admin'){
            $query = Task::where('id', $request->id);;
        }else{
            $query = Task::where('id', $request->id)->where('user_id', auth()->user()->id);
        }

        if($query->value('status') == 'running'){
            $query->update(['status' => 'archive']);
            $response['success'] = get_phrase('Moved to archive');
        }else{
            $query->update(['status' => 'running']);
            $response['success'] = get_phrase('Removed from archive');
        }
        $response['fadeOut'] = '#task-list'.$request->id;
        return json_encode($response);

    }
    


}
