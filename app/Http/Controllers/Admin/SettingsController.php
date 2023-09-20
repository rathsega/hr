<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance, Setting, FileUploader};
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

        return redirect()->back()->with('success_message', get_phrase('Settings updated successfully'));
    }

    function smtp_settings(){
        return view('admin.system.smtp_settings');
    }

    function about(){
        return view('admin.system.about');
    }

    function update_logo(Request $request){

        foreach($request->all() as $type => $description){
            if($type == '_token') continue;

            if($type == 'favicon'){
                $description = FileUploader::upload($request->$type, 'uploads/system/logo', 50);
            }else{
                $description = FileUploader::upload($request->$type, 'uploads/system/logo', 250);
            }

            if(Setting::where('type', $type)->count()){
                remove_file(get_settings($type));
                Setting::where('type', $type)->update(['description' => $description]);
            }else{
                Setting::where('type', $type)->insert(['type' => $type, 'description' => $description]);
            }
            
        }

        return redirect()->back()->with('success_message', get_phrase('System logo changed successfully'));
    }

}
