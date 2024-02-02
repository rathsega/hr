<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Leave_application, FileUploader};
use Mail;

class LeaveApplicationController extends Controller
{

    function index(Request $request){
        if(auth()->user()->role == 'manager'){
            $page_data['users'] = User::where('role', '!=', 'admin')->where('manager', auth()->user()->id)->orWhere('id', auth()->user()->id)->where('status', 'active')->orderBy('sort')->get();
        }else{
            $page_data['users'] = User::where('id', auth()->user()->id)->get();
        }
        return view(auth()->user()->role.'.leave.index', $page_data);
    }

    function store(Request $request){

        if(auth()->user()->role == 'manager'){
            $data['user_id'] = $request->user_id;
        }else{
            $data['user_id'] = auth()->user()->id;
        }

        $start_timestamp = strtotime($request->from_date);
        $end_timestamp = strtotime($request->to_date);

        if($start_timestamp > $end_timestamp || $start_timestamp == $end_timestamp){
            return redirect()->back()->withInput()->with('error_message', get_phrase('Please select correct date range'));
        }

        $this->validate($request, [
            'attachment' => 'mimes:pdf,jpg,jpeg,png,gif,svg,webp',
            'from_date' => 'required',
            'to_date' => 'required',
            'reason' => 'required',
            'leave_type' => 'required',
        ]);

        $data['status'] = 'pending';
        $data['from_date'] = $start_timestamp;
        $data['to_date'] = $end_timestamp;
        $data['leave_type'] = $request->leave_type;

        $data['working_day'] = (($end_timestamp - $start_timestamp) + 1) / 86400;
        $data['reason'] = $request->reason;

        if($request->attachment){
            $data['attachment'] = FileUploader::upload($request->attachment, 'uploads/leave-attachment');
        }

        Leave_application::insert($data);

        return redirect()->back()->with('success_message', get_phrase('Your request has been successfully submitted'));
    }

    function delete(Request $request){
        if(auth()->user()->role == 'manager'){
            Leave_application::where('id', $request->id)->delete();
        }else{
            Leave_application::where('id', $request->id)->where('user_id', auth()->user()->id)->delete();
        }
        return redirect()->back()->with('success_message', get_phrase('Leave request deleted successfully'));
    }

    function change_status($id, Request $request){

        $leave_report = Leave_application::where('id', $id)->first();
        $to = User::where('id', $leave_report->user_id)->first();

        if($request->status == 'hr_approved'){
            $data['status'] = 'hr_approved';
            $subject = get_phrase("Your Leave Request Has Been Approved By HR");
        }elseif($request->status == 'manager_approved'){
            $data['status'] = 'manager_approved';
            $subject = get_phrase("Your leave request has been approved by your manager, Yet to approved by HR");
        }elseif($request->status == 'manager_rejected'){
            $data['status'] = 'manager_rejected';
            $subject = get_phrase("Leave Request Denied By Your Manager");
        }elseif($request->status == 'hr_rejected'){
            $data['status'] = 'hr_rejected';
            $subject = get_phrase("Leave Request Denied By HR");
        }elseif($request->status == 'pending'){
            $data['status'] = 'pending';
        }

        Leave_application::where('id', $id)->update($data);
        
        if($request->message){
            try{
                Mail::raw($request->message, function ($message) use ($subject, $to) {
                    $message->from(get_settings('system_email'), get_settings('website_title'))
                    ->to($to->email, $to->name)
                    ->subject($subject);
                });
                
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success_message', get_phrase('Request has been approved'));
    }

}
