<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Leave_application, FileUploader};
use Mail;

class LeaveApplicationController extends Controller
{

    function index(Request $request){
        if(auth()->user()->role == 'admin'){
            $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        }else{
            $page_data['users'] = User::where('id', auth()->user()->id)->get();
        }
        return view(auth()->user()->role.'.leave.index', $page_data);
    }

    function store(Request $request){

        
        $data['user_id'] = auth()->user()->id;

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
        ]);

        $data['status'] = 'pending';
        $data['from_date'] = $start_timestamp;
        $data['to_date'] = $end_timestamp;

        $data['working_day'] = (($end_timestamp - $start_timestamp) + 1) / 86400;
        $data['reason'] = $request->reason;

        if($request->attachment){
            $data['attachment'] = FileUploader::upload($request->attachment, 'uploads/leave-attachment');
        }

        Leave_application::insert($data);

        return redirect()->back()->with('success_message', get_phrase('Your request has been successfully submitted'));
    }

    function delete(Request $request){
        Leave_application::where('id', $request->id)->where('user_id', auth()->user()->id)->where('status', 'pending')->delete();
        return redirect()->back()->with('success_message', get_phrase('Leave request deleted successfully'));
    }

}
