<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance};
use Session, Image;

class AdminController extends Controller
{
    function __construct(){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
    function dashboard(){
        return view('admin.dashboard');
    }

    function timesheet(){
        $page_data['users'] = User::orderBy('id', 'asc')->get();
        return view('admin.timesheet', $page_data);
    }
    function add_working_log(Request $request){
        $this->validate($request,[
            'description'=>'required',
            'user_id' => 'required'
        ]);

        $from_date = strtotime($request->from_date);
        $to_date = strtotime($request->to_date);

        $data['user_id'] = $request->user_id;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['description'] = $request->description;
        $data['working_time'] = $to_date - $from_date;

        if($data['working_time'] <= 0){
            return redirect()->back()->withInput()->with('error_message', "From time and to time can't be same");
        }

        //check time duplication
        // $query = Timesheet::where('user_id', $data['user_id'])->where('from_date', '<=', $from_date)->where('to_date', '>=', $from_date);
        // $query->orWhere(function($query) use ($to_date){
        //      $query->where('from_date', '<=', $to_date)->where('to_date', '>=', $to_date);
        // });

        // if($query->get()->count() > 0){
        //     return redirect()->back()->withInput()->with('error_message', 'Multiple entries cannot be added at the same time');
        // }

        $response = Timesheet::insert($data);
        return redirect()->back()->with('success_message', __('New working log has been added'));
    }





    function task_manager(){
        $page_data['staffs'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        return view('admin.task_manager', $page_data);
    }

    function task_manager_update($user_id, Request $request){

        $data['description'] = $request->description;

        if(Task::where('user_id', $user_id)->get()->count() > 0){
            $response = Task::where('user_id', $user_id)->update($data);
        }else{
            $data['user_id'] = $user_id;
            $response = Task::insert($data);
        }

        if($response){
            Session::flash('success_message', __('Task updated'));
        }else{
            Session::flash('error_message', __('Someting is wrong!'));
        }

        return redirect(route('admin.task_manager', ['expand-user' => $user_id]));
    }

    //attendance
    function attendance(){
        $page_data['users'] = User::orderBy('id', 'asc')->get();
        return view('admin.attendance', $page_data);
    }

    function attendance_add(Request $request){

        $start_timestamp_of_selected_date = strtotime(date('d M Y', strtotime($request->time)));
        $end_timestamp_of_selected_date = strtotime(date('d M Y 23:59:59', strtotime($request->time)));
        
        if(!empty($request->note)){
            $data['note'] = $request->note;
        }

        if($request->check_in_out == 'checkin'){

            if(date('H', strtotime($request->time)) == 10 && date('i', strtotime($request->time)) > 30){
                $data['late_entry'] = 1;
            }elseif(date('H', strtotime($request->time)) > 10){
                $data['late_entry'] = 1;
            }

            $data['working_time'] = 0;

            $data['user_id'] = $request->user_id;
            $data['checkin'] = strtotime($request->time);

            $number_of_entry = Attendance::where('user_id', $request->user_id)->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date)->get()->count();
            if($number_of_entry > 0){
                return redirect()->back()->withInput()->with('error_message', __('There is already an entry for your selected date'));
            }

            Attendance::insert($data);
            return redirect()->back()->with('success_message', __('Attendance has been added'));
        }else{
            $query = Attendance::where('user_id', $request->user_id)->where('checkin', '>=', $start_timestamp_of_selected_date)->where('checkin', '<=', $end_timestamp_of_selected_date);


            if($request->time != null && gmdate('H', strtotime($request->time) - $query->value('checkin')) < 8){
                $data['early_leave'] = 1;
            }else{
                $data['early_leave'] = null;
            }

            $data['working_time'] = (strtotime($request->time) - $query->value('checkin')) + 1;
            $data['checkout'] = strtotime($request->time);

            $query->update($data);
            return redirect()->back()->with('success_message', __('Attendance has been updated'));
        }
        

        $response = Timesheet::insert($data);
        return redirect()->back()->with('success_message', __('New working log has been added'));
    }

    function leave_application_add(Request $request){
        $data['user_id'] = $request->user_id;
        $data['status'] = 'approved';
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

    function staff(){
        $page_data['active_staffs'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort', 'asc')->get();
        $page_data['inactive_staffs'] = User::where('role', '!=', 'admin')->where('status', 'inactive')->orderBy('sort', 'asc')->get();
        return view('admin.staff', $page_data);
    }

    function staff_add(Request $request){

        $this->validate($request,[
            'name'=>'required',
            'email' => 'required|string|email|max:255|unique:App\Models\User,email',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);


        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->role;
        $data['status'] = 'active';
        $data['designation'] = $request->designation;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        if($request->photo){
            $data['photo'] = random(20).'.'.$request->photo->extension();
            //Image optimization
            Image::make($request->photo->path())->orientate()->resize(200, null, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save(public_path() . '/uploads/user-image/' . $data['photo']);
        }


        $response = User::insert($data);


        if($response){
            return redirect()->back()->with('success_message', __('New staff added successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function staff_update($user_id = "", Request $request){

        $this->validate($request,[
            'name'=>'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);


        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['designation'] = $request->designation;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if($request->photo){
            removeFile('uploads/user-image/'.User::where('id', $user_id)->value('photo'));

            $data['photo'] = random(20).'.'.$request->photo->extension();

            //Image optimization
            Image::make($request->photo->path())->orientate()->resize(200, null, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save(public_path() . '/uploads/user-image/' . $data['photo']);
        }

        if(User::where('email', $request->email)->where('id', '!=', $user_id)->get()->count() > 0){
            return redirect()->back()->withInput()->with('error_message', __('Email duplication'));
        }


        $response = User::where('id', $user_id)->update($data);


        if($response){
            return redirect()->back()->with('success_message', __('User data updated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function staff_status($status = "", $user_id = ""){
        User::where('id', $user_id)->update(['status' => $status]);
        return redirect()->back()->with('success_message', __('Status changed successfully'));
    }

    function staff_delete($user_id = ""){
        removeFile('uploads/user-image/'.User::where('id', $user_id)->value('photo'));
        User::where('id', $user_id)->delete();
        return redirect()->back()->with('success_message', __('Staff deleted successfully'));
    }

    function staff_sort(Request $request){

        if(is_array($request->active_user_ids)){
            foreach ($request->active_user_ids as $key => $active_user_id) {
                ++$key;
                User::where('id', $active_user_id)->update(['sort' => $key]);
            }
        }

        if(is_array($request->inactive_user_ids)){
            foreach ($request->inactive_user_ids as $key => $inactive_user_id) {
                ++$key;
                User::where('id', $inactive_user_id)->update(['sort' => $key]);
            }
        }

        return redirect()->back()->with('success_message', __('User sorted successfully'));
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


    function assessment_rating_update(Request $request){

        if(isset($request->date_time) && $request->date_time != ''){
            $selected_timestamp_of_month = strtotime(date('1 M Y', strtotime($request->date_time)));
        }else{
            $selected_timestamp_of_month = strtotime(date('1 M Y'));
        }

        $start_timestamp = $selected_timestamp_of_month;
        $end_timestamp = strtotime(date('t M Y 23:59:59', $start_timestamp));

        $data['user_id'] = $request->user_id;
        $data['type'] = $request->type;
        $data['rating'] = $request->rating;
        $data['date_time'] = strtotime($request->date_time);
        $data['description'] = '';

        $query = Staff_performance::where('user_id', $request->user_id)->where('type', $request->type)->where('date_time', '>=', $start_timestamp)->where('date_time', '<=', $end_timestamp);

        if($query->get()->count() > 0){
            Staff_performance::where('id', $query->first()->id)->update($data);
        }else{
            Staff_performance::insert($data);
        }
        return redirect()->back()->with('success_message', __('Assessment rating updated successfully'));
    }






}
