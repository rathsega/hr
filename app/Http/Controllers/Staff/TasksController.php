<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;
use Carbon\Carbon;

class TasksController extends Controller
{

    function index($tasks_type = "archive"){
        $page_data['tasks_type'] = $tasks_type;
        return view(auth()->user()->role.'.tasks.index', $page_data);
    }

    function store($user_id, Request $request){
        
        $this->validate($request,[
            'description'=>'required',
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['description'] = $request->description;
        $data['is_completed'] = 0;
        $data['status'] = 'running';

        $id = Task::insertGetId($data);
        $page_data['task'] = Task::find($id);
        
        $response['prepend'] = ['elem' => '#user-task-list'.$user_id, 'content' => view(auth()->user()->role.'.tasks.task', $page_data)->render()];
        return json_encode($response);
    }

    function update($id, Request $request){
        $this->validate($request,[
            'description'=>'required',
        ]);

        $data['description'] = $request->description;

        $query = Task::where('id', $request->id)->where('user_id', auth()->user()->id);
        $query->update($data);
    }

    function task_completion(Request $request){
        $query = Task::where('id', $request->id)->where('user_id', auth()->user()->id);
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
        $query = Task::where('id', $request->id)->where('user_id', auth()->user()->id);

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

    function task_delete($id = ""){
        $query = Task::where('id', $id)->where('user_id', auth()->user()->id);
        if($query->delete()){
            $response['success'] = get_phrase('Task deleted successfully');
            $response['fadeOut'] = '#task-list'.$id;
        }else{
            $response['success'] = get_phrase("Not authorised to delete this task for you");
            $response['fadeOut'] = '#task-list'.$id;
        }
        return json_encode($response);
    }

    function sort(Request $request){
        foreach(explode(',', $request->sort_value) as $key => $item_id){
            if($item_id == '')
                continue;

            Task::where('id', $item_id)->where('user_id', auth()->user()->id)->update(['sort' => $key]);
        }

        $response['success'] = get_phrase('Items has been sorted');
        return json_encode($response);
    }
    


}
