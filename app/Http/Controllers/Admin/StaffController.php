<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application};
use Session;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class StaffController extends Controller
{

    function index(){
        $page_data['active_staffs'] = User::where('status', 'active')->where('role', 'staff')->orderBy('sort')->get();
        $page_data['inactive_staffs'] = User::where('status', 'inactive')->where('role', 'staff')->orderBy('sort')->get();
        return view(auth()->user()->role.'.staff.index', $page_data);
    }

    function store(Request $request){

        $this->validate($request,[
            'name'=>'required',
            'email' => 'required|email|unique:users',
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

    function update($user_id = "", Request $request){

        $this->validate($request,[
            'name'=>'required',
            'email' => "required|email|unique:users,email,$user_id",
            'role' => 'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['designation'] = $request->designation;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if($request->photo){
            remove_file('uploads/user-image/'.User::where('id', $user_id)->value('photo'));

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

    function delete($user_id = ""){
        remove_file('uploads/user-image/'.User::where('id', $user_id)->value('photo'));
        User::where('id', $user_id)->delete();
        return redirect()->back()->with('success_message', __('Staff deleted successfully'));
    }

    function staff_status($status = "", $user_id = ""){
        User::where('id', $user_id)->update(['status' => $status]);
        return redirect()->back()->with('success_message', __('Status changed successfully'));
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

    function profile($tab = "", $user_id = "", Request $request){
        $page_data['user'] = User::where('id', $user_id)->first();
        $page_data['tab'] = $tab;
        return view(auth()->user()->role.'.staff.profile', $page_data);
    }

    function profile_update($user_id = "", Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email' => "required|email|unique:users,email,$user_id",
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['designation'] = $request->designation;
        $data['phone'] = $request->phone;
        $data['alternative_phone'] = $request->alternative_phone;
        $data['rel_of_alternative_phone'] = $request->rel_of_alternative_phone;
        $data['blood_group'] = $request->blood_group;
        $data['gender'] = $request->gender;
        $data['birthday'] = date('Y-m-d H:i:s', strtotime($request->birthday));
        $data['present_address'] = $request->present_address;
        $data['permanent_address'] = $request->permanent_address;
        $data['bio'] = $request->bio;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if($request->photo){
            remove_file('uploads/user-image/'.User::where('id', $user_id)->value('photo'));
            $data['photo'] = random(20).'.'.$request->photo->extension();
            //Image optimization
            Image::make($request->photo->path())->orientate()->resize(200, null, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save(public_path() . '/uploads/user-image/' . $data['photo']);
        }
        
        $response = User::where('id', $user_id)->update($data);


        if($response){
            return redirect()->back()->with('success_message', __('User data updated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

}