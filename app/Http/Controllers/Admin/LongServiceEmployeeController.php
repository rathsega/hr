<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{LongServiceEmployee, User};
use Illuminate\Support\Facades\Hash;
use Mail;

class LongServiceEmployeeController extends Controller
{
    function index()
    {
        $page_data = [];
        $page_data['users'] = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        $page_data['lses'] = DB::select("SELECT e.*, u.id as user_id, u.name from long_service_employee as e left join users as u on u.id = e.user_id");
        return view(auth()->user()->role . '.awards.lse.index', $page_data);
    }

    

    function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'service' => 'required',
        ]);

        $data['user_id'] = $request->user_id;
        $data['service'] = $request->service;
        $data['visibility'] = $request->visibility == 'on' ? 1 : 0;

        LongServiceEmployee::insert($data);

        

        return redirect()->back()->with('success_message', __('Long service employee has been added'));
    }

    function update($lse_id = "", Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required',
            'service' => 'required'
        ]);

        $data['user_id'] = $request->user_id;
        $data['service'] = $request->service;
        $data['visibility'] = $request->visibility == 'on' ? 1 : 0;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $response = LongServiceEmployee::where('id', $lse_id)->update($data);


        if ($response) {
            return redirect()->back()->with('success_message', __('Long service employee data updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function delete($lse_id = "")
    {
        LongServiceEmployee::where('id', $lse_id)->delete();
        return redirect()->back()->with('success_message', __('Long service employee deleted successfully'));
    }
}
