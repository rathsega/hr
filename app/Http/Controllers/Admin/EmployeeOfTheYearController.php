<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{EmployeeOfTheYear, User};
use Illuminate\Support\Facades\Hash;
use Mail;

class EmployeeOfTheYearController extends Controller
{
    function index()
    {
        $page_data = [];
        $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        $page_data['eotys'] = DB::select("SELECT e.*, u.id as user_id, u.name from employee_of_the_year as e left join users as u on u.id = e.user_id");
        return view(auth()->user()->role . '.awards.eoty.index', $page_data);
    }

    

    function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'year' => 'required'
        ]);

        $data['user_id'] = $request->user_id;
        $data['year'] = $request->year;
        $data['visibility'] = $request->visibility == 'on' ? 1 : 0;

        EmployeeOfTheYear::insert($data);

        

        return redirect()->back()->with('success_message', __('Employee Of The year has been added'));
    }

    function update($eoty_id = "", Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required',
            'year' => 'required'
        ]);

        $data['user_id'] = $request->user_id;
        $data['year'] = $request->year;
        $data['visibility'] = $request->visibility == 'on' ? 1 : 0;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $response = EmployeeOfTheYear::where('id', $eoty_id)->update($data);


        if ($response) {
            return redirect()->back()->with('success_message', __('Employee of the year data updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function delete($eoty_id = "")
    {
        EmployeeOfTheYear::where('id', $eoty_id)->delete();
        return redirect()->back()->with('success_message', __('Employee of the year deleted successfully'));
    }
}
