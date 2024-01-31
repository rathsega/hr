<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

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
        if(auth()->user()->role == 'manager'){
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
        $data['created_at'] = date('Y-m-d H:i:s', strtotime($request->date_time));
        $data['updated_at'] = date('Y-m-d H:i:s', strtotime($request->date_time));
        $data['description'] = $request->description;

        Assessment::insert($data);
        return redirect(route('manager.assessment'))->with('success_message', __('Assessment added successfully'));
    }

    function update($id = "", Request $request){
        if(auth()->user()->role == 'manager'){
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
        $data['created_at'] = date('Y-m-d H:i:s', strtotime($request->date_time));
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['description'] = $request->description;

        $query->update($data);
        return redirect(route('manager.assessment'))->with('success_message', __('Assessment updated successfully'));
    }

    function delete($id = ""){
        if(auth()->user()->role == 'manager'){
            $query = Assessment::where('id', $id);
        }else{
            $query = Assessment::where('id', $id)->where('user_id', auth()->user()->id);
        }

        $query->delete();
        return redirect(route('manager.assessment'))->with('success_message', __('Assessment deleted successfully'));
    }
    

}
