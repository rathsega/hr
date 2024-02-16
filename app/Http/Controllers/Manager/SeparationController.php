<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\{Separation};
use Session;

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
        $data['actual_last_working_day'] = date('Y-m-d', time() + (3600*24*auth()->user()->notice_period_in_days));
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
        $page_data['separation'] = DB::select("select *, s.id as id, s.status as status, u.id as user_id from separation as s INNER join users as u on u.id = s.user_id where s.id=".$request->id);
        
        return view(auth()->user()->role.'.separation.view', $page_data);
    }

    function manager_approvals(Request $request){
        $this->validate($request,[
            'action'=>'required'
        ]);
        $data = [];
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
            return redirect()->back()->with('success_message', __('Status updated successfully'));
        }else{
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }
    

}