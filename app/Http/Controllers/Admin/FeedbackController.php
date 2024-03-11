<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Feedback};


class FeedbackController extends Controller
{
    function index(){
        $page_data = [];
        $page_data['feedbacks'] = DB::select("select f.*, u.name, u.email, u.emp_id from feedback as f left join users as u on u.id = f.user_id");
    return view(auth()->user()->role.'.feedback.index', $page_data);
    }

    function store(Request $request){
        $this->validate($request,[
            'feedback'=>'required'
        ]);


        $data['user_id'] = auth()->user()->id;
        $data['feedback'] = $request->feedback;

        $id = Feedback::insert($data);

        return redirect()->back()->with('success_message', __('Feedback has been added'));
    }

}