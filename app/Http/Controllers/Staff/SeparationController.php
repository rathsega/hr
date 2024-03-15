<?php

namespace App\Http\Controllers\Staff;
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
        $data['initiated_date'] = date('Y-m-d H:i:s');

        $response = Separation::insert($data);

        $to_users = User::where('id', auth()->user()->manager)->orWhere('email','hr@zettamine.com')->get();
        
        $separation_details= "Name : " . auth()->user()->name . "\r\n Email : " . auth()->user()->email . "\r\n EMP ID : " . auth()->user()->emp_id . "\r\n" . "Reason : " . $request->reason . "\r\n";
        if($request->user_proposed_last_working_day){
            $separation_details .= "Proposed last Working Day : " . date("d-m-Y", strtotime($request->user_proposed_last_working_day))  . "\r\n";
        }
        $separation_details .= "\r\n"; 
        $subject = "Seperation Initiated by " . auth()->user()->name . "(" . auth()->user()->emp_id . ")" ;
        if($response){
            foreach($to_users as $key => $to){
                $email_message = "Hi ". $to->name . ", \r\n\r\n Separation initiated by ".auth()->user()->name . ", please find the below details. ". $separation_details ."\r\n\r\n" . "\r\n\r\nRegards, \r\n Zettamine Workplace.";
                try{
                
                    Mail::raw($email_message, function ($email_message) use ($subject, $to) {
                        $email_message->from(get_settings('system_email'), get_settings('website_title'))
                        ->to($to->email, $to->name)
                        ->subject($subject);
                    });
                    
                } catch (\Exception $e) {
                    \Log::error('Email sending failed: ' . $e->getMessage());
                }
            }
            
            return redirect()->back()->with('success_message', __('Separation initiated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function view(Request $request){
        $page_data['separation'] = DB::select("select *, s.id as id, s.status as status, u.id as user_id from separation as s INNER join users as u on u.id = s.user_id where s.id=".$request->id);
        
        return view(auth()->user()->role.'.separation.view', $page_data);
    }

}