<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{Feedback};
use Session, Image;
use Carbon\Carbon;

use Jenssegers\Agent\Agent;

class FeedbackController extends Controller
{
    function index(){
        return view('staff.feedback.index');
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