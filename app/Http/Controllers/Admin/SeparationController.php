<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\{Separation, User};
use Session;
use Mail;

class SeparationController extends Controller
{

    function index(){

        $page_data['title'] = "Separation";
        
        return view(auth()->user()->role.'.separation.index', $page_data);
    }

    function store(Request $request){
        $this->validate($request,[
            'reason'=>'required'
        ]);


        $data['reason'] = $request->reason;
        $data['actual_last_working_day'] = date('Y-m-d', time() + (3600*24*90));
        $data['user_proposed_last_working_day'] = $request->user_proposed_last_working_day;
        $data['user_id'] = auth()->user()->id;
        $data['status'] = 'Pending at Manager';
        $data['initiated_date'] = date('Y-m-d');

        $response = Separation::insert($data);


        if($response){
            return redirect()->back()->with('success_message', __('Separation initiated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function view(Request $request){
        $page_data['separation'] = DB::select("select *,  s.id as id, s.status as status, u.id as user_id from separation as s INNER join users as u on u.id = s.user_id where s.id=".$request->id);
        
        return view(auth()->user()->role.'.separation.view', $page_data);
    }

    function manager_approvals(Request $request){
        $this->validate($request,[
            'action'=>'required'
        ]);

        $separation_details = Separation::where('id', $request->id)->first();
        $to = User::where('id', $separation_details->user_id)->first();

        $data['reporting_manager_comments'] = $request->reporting_manager_comments;
        if($request->action == 'Approve'){
            $data['reporting_manager_approval_status'] = 'approved';
            $data['status'] = 'Pending at HR Manager';
        }
        if($request->action == 'Reject'){
            $data['reporting_manager_approval_status'] = 'rejected';
            $data['status'] = 'Rejected by Manager';
        }
        $data['reporting_manager_approved_or_rejected_date'] = date('Y-m-d');

        $response = Separation::where('id',$request->id)->update($data);


        if($response){
            try{
                $subject = "Your separation is  ".$data['status'];
                Mail::raw("Hi Dear\n, your separation is  {$data['status']}", function ($message) use ($subject, $to) {
                    $message->from(get_settings('system_email'), get_settings('website_title'))
                    ->to($to->email, $to->name)
                    ->subject($subject);
                });
                
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
            return redirect()->back()->with('success_message', __('Status updated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function it_manager_approvals(Request $request){
        $this->validate($request,[
            'action'=>'required'
        ]);

        $data['it_manager_comments'] = $request->it_manager_comments;
        if($request->action == 'Approve'){
            $data['it_manager_approval_status'] = 'approved';
            $data['status'] = 'Pending at Finance Manager';
            $subject = "Your separation is  Approved by IT Manager";
            $email_message = "Your Separation is Approved by IT Manager, and ".$data['status'];
        }
        if($request->action == 'Reject'){
            $data['it_manager_approval_status'] = 'rejected';
            $data['status'] = 'Rejected by IT Manager';
            $subject = "Your separation is  Rejected by IT Manager";
            $email_message = "Your Separation is Rejected by IT Manager";
        }
        $data['it_manager_approved_or_rejected_date'] = date('Y-m-d');

        $response = Separation::where('id',$request->id)->update($data);
        $separation_details = Separation::where('id', $request->id)->first();
        $to = User::where('id', $separation_details->user_id)->first();

        if($data['it_manager_comments']){
            $email_message = "Hi ". $to->name . ", \r\n\r\n".$email_message ."\r\n\r\n" . "Your IT Manager Comments : " . $data['it_manager_comments'] . "\r\n\r\nRegards, \r\nHR Team.";
        }

        if($response){
            try{
                
                Mail::raw($email_message, function ($email_message) use ($subject, $to) {
                    $email_message->from(get_settings('system_email'), get_settings('website_title'))
                    ->to($to->email, $to->name)
                    ->subject($subject);
                });
                
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
            return redirect()->back()->with('success_message', __('Status updated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function finance_manager_approvals(Request $request){
        $this->validate($request,[
            'action'=>'required'
        ]);

        $data['finance_manager_comments'] = $request->finance_manager_comments;
        if($request->action == 'Approve'){
            $data['finance_manager_approval_status'] = 'approved';
            $data['status'] = 'Relieved';
            $subject = "Your separation process is completed";
            $email_message = " Your Separation process is completed and You have relieved.";
        }
        if($request->action == 'Reject'){
            $data['finance_manager_approval_status'] = 'rejected';
            $data['status'] = 'Rejected by Finance Manager';
            $subject = "Your separation is  ".$data['status'];
            $email_message = " Your Separation is Rejected by Finance Manager.";
        }
        $data['finance_manager_approved_or_rejected_date'] = date('Y-m-d');

        $response = Separation::where('id',$request->id)->update($data);
        $separation_details = Separation::where('id', $request->id)->first();
        $to = User::where('id', $separation_details->user_id)->first();

        if($data['finance_manager_comments']){
            $email_message = "Hi ". $to->name . ", \r\n\r\n".$email_message ."\r\n\r\n" . "Your Finance Manager Comments : " . $data['finance_manager_comments'] . "\r\n\r\nRegards, \r\nHR Team.";
        }

        if($response){
            try{
                
                Mail::raw($email_message, function ($email_message) use ($subject, $to) {
                    $email_message->from(get_settings('system_email'), get_settings('website_title'))
                    ->to($to->email, $to->name)
                    ->subject($subject);
                });
                
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
            return redirect()->back()->with('success_message', __('Status updated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function hr_manager_approvals(Request $request){
        $this->validate($request,[
            'action'=>'required'
        ]);

        $data['hr_manager_comments'] = $request->hr_manager_comments;
        if($request->action == 'Approve'){
            $data['hr_manager_approval_status'] = 'approved';
            $data['status'] = 'Pending at IT Manager';
            $subject = "Your separation is  Approved by HR Manager";
            $email_message = " Your Separation is Approved by HR Manager.";
        }
        if($request->action == 'Reject'){
            $data['hr_manager_approval_status'] = 'rejected';
            $data['status'] = 'Rejected by HR Manager';
            $email_message = " Your Separation is Rejected by HR Manager.";
        }
        $data['hr_manager_approved_or_rejected_date'] = date('Y-m-d');
        if($request->hr_proposed_last_working_day){
            $data['hr_proposed_last_working_day'] = date('Y-m-d', strtotime($request->hr_proposed_last_working_day));
            $email_message .= "\r\n\r\nHR Proposed Release Date : " . date('Y-m-d', strtotime($request->hr_proposed_last_working_day));
        }

        $response = Separation::where('id',$request->id)->update($data);
        $separation_details = Separation::where('id', $request->id)->first();
        $to = User::where('id', $separation_details->user_id)->first();

        if($data['hr_manager_comments']){
            $email_message = "Hi ". $to->name . ", \r\n\r\n".$email_message ."\r\n\r\n" . "Your HR Manager Comments : " . $data['hr_manager_comments'] . "\r\n\r\nRegards, \r\nHR Team.";
        }

        if($response){
            try{
                Mail::raw($email_message, function ($email_message) use ($subject, $to) {
                    $email_message->from(get_settings('system_email'), get_settings('website_title'))
                    ->to($to->email, $to->name)
                    ->subject($subject);
                });
                
            } catch (\Exception $e) {
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
            return redirect()->back()->with('success_message', __('Status updated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }
    

}