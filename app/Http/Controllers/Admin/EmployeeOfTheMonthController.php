<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{EmployeeOfTheMonth, User};
use Illuminate\Support\Facades\Hash;
use Mail;

class EmployeeOfTheMonthController extends Controller
{
    function index()
    {
        $page_data = [];
        $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        $page_data['eotms'] = DB::select("SELECT e.*, u.id as user_id, u.name from employee_of_the_month as e left join users as u on u.id = e.user_id");
        return view(auth()->user()->role . '.eotm.index', $page_data);
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

        EmployeeOfTheMonth::insert($data);

        

        return redirect()->back()->with('success_message', __('Employee Of The Month has been added'));
    }

    function update($eotm_id = "", Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required',
            'month' => 'required',
            'year' => 'required'
        ]);

        $data['user_id'] = $request->user_id;
        $data['month'] = $request->month;
        $data['year'] = $request->year;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $response = EmployeeOfTheMonth::where('id', $eotm_id)->update($data);


        if ($response) {
            return redirect()->back()->with('success_message', __('Employee of the month data updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function delete($eotm_id = "")
    {
        EmployeeOfTheMonth::where('id', $eotm_id)->delete();
        return redirect()->back()->with('success_message', __('Employee of the month deleted successfully'));
    }
}
