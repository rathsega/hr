<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;

class MyProfileController extends Controller
{
    function index($tab = ""){
        if($tab == ''){
            $tab = 'info';
        }
        
        $page_data['user'] = User::where('id', auth()->user()->id)->first();
        $page_data['tab'] = $tab;
        return view('staff.my_profile.index', $page_data);
    }

    function update($user_id = "", Request $request){

        $this->validate($request,[
            'name'=>'required',
            'email' => "required|email|unique:users,email,$user_id",
            'role' => 'required'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['role'] = $request->role;
        $data['designation'] = $request->designation;
        $data['updated_at'] = date('Y-m-d H:i:s');

        $data['blood_group'] = $request->blood_group;
        $data['phone'] = $request->phone;
        $data['alternative_phone'] = $request->alternative_phone;
        $data['rel_of_alternative_phone'] = $request->rel_of_alternative_phone;
        $data['blood_group'] = $request->blood_group;
        $data['gender'] = $request->gender;
        $data['birthday'] = date('Y-m-d H:i:s', strtotime($request->birthday));
        $data['present_address'] = $request->present_address;
        $data['permanent_address'] = $request->permanent_address;
        $data['bio'] = $request->bio;
        $data['aadhar_number'] = $request->aadhar_number;
        $data['pan_number'] = $request->pan_number;
        $data['uan_number'] = $request->uan_number;
        $data['pf_number'] = $request->pf_number;
        $data['passport_number'] = $request->passport_number;
        $data['passport_expiry_date'] = $request->passport_expiry_date;
        $data['bank_name'] = $request->bank_name;
        $data['bank_account_number'] = $request->bank_account_number;
        $data['ifsc_code'] = $request->ifsc_code;

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

    function change_password(){
        return view('staff.my_profile.profile_change_password');
    }

    function password_update(Request $request){

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password'
        ]);
        $user_details = User::where('id', auth()->user()->id)->first();

        if(Hash::check($request->current_password, $user_details->password)){
            $data['password'] = Hash::make($request->new_password);
        }else{
            return redirect()->back()->with('error_message', get_phrase('Current password is wrong'));
        }

        User::where('id', auth()->user()->id)->update($data);
        return redirect()->back()->with('success_message', get_phrase('Your account password has been changed'));
    }
}
