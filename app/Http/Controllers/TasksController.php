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

    function update($id, Request $request){
        $this->validate($request,[
            'description'=>'required',
        ]);

        $data['description'] = $request->description;

        Task::where('id', $id)->update($data);
        Task::find($id);
    }

    function task_completion(Request $request){
        $query = Task::where('id', $request->id);

        if($query->value('is_completed') == 1){
            Task::where('id', $request->id)->update(['is_completed' => 0]);
            $response['removeClass'] = ['elem' => '#task-list'.$request->id, 'content' => 'completed'];
            $response['success'] = get_phrase('Marked as incompleted');
        }else{
            Task::where('id', $request->id)->update(['is_completed' => 1]);
            $response['addClass'] = ['elem' => '#task-list'.$request->id, 'content' => 'completed'];
            $response['success'] = get_phrase('Marked as completed');
        }

        return json_encode($response);
    }

    function task_status(Request $request){
        $query = Task::where('id', $request->id);

        if($query->value('status') == 'running'){
            Task::where('id', $request->id)->update(['status' => 'archive']);
            $response['success'] = get_phrase('Moved to archive');
        }else{
            Task::where('id', $request->id)->update(['status' => 'running']);
            $response['success'] = get_phrase('Removed from archive');
        }
        $response['fadeOut'] = '#task-list'.$request->id;
        return json_encode($response);

    }
    


}
