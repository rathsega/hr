<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance, Setting};
use Session, Image;
use Carbon\Carbon;

class SettingsController extends Controller
{

    function system_settings(){
        return view('admin.system.index');
    }

    function update(Request $request){


        foreach($request->all() as $type => $description){
            if($type == '_token') continue;
            if(Setting::where('type', $type)->count()){
                Setting::where('type', $type)->update(['description' => $description]);
            }else{
                Setting::where('type', $type)->insert(['type' => $type, 'description' => $description]);
            }
        }

        return redirect()->back()->with('success_message', get_phrase('System settings updated successfully'));
    }


}
