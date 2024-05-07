<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{EmployeeOfTheQuarter, User};
use Illuminate\Support\Facades\Hash;
use Mail;

class EmployeeOfTheQuarterController extends Controller
{
    function index()
    {
        $page_data = [];
        $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        $page_data['eotqs'] = DB::select("SELECT e.*, u.id as user_id, u.name from employee_of_the_quarter as e left join users as u on u.id = e.user_id");
        return view(auth()->user()->role . '.awards.eotq.index', $page_data);
    }

    

    function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        $data['user_id'] = $request->user_id;
        $data['month'] = $request->month;
        $data['year'] = $request->year;
        $data['visibility'] = $request->visibility == 'on' ? 1 : 0;

        EmployeeOfTheQuarter::insert($data);

        

        return redirect()->back()->with('success_message', __('Employee Of The Quarter has been added'));
    }

    function update($eotq_id = "", Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        $data['user_id'] = $request->user_id;
        $data['month'] = $request->month;
        $data['year'] = $request->year;
        $data['visibility'] = $request->visibility == 'on' ? 1 : 0;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $response = EmployeeOfTheQuarter::where('id', $eotq_id)->update($data);


        if ($response) {
            return redirect()->back()->with('success_message', __('Employee of the quarter data updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function delete($eotq_id = "")
    {
        EmployeeOfTheQuarter::where('id', $eotq_id)->delete();
        return redirect()->back()->with('success_message', __('Employee of the quarter deleted successfully'));
    }
}
