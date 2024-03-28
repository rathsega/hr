<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Quotes};
use Illuminate\Support\Facades\Hash;
use Mail;

class EmployersQuote extends Controller
{
    function index()
    {
        $page_data = [];
        $page_data['quotes'] = DB::select("SELECT q.*, u.id as user_id, u.name from quotes as q inner join users as u on u.id = q.user_id");
        return view(auth()->user()->role . '.quotes.index', $page_data);
    }

    

    function store(Request $request)
    {
        $this->validate($request, [
            'quote' => 'required|max:150',
            'from_date' => 'required',
            'to_date' => 'required',
            'user_id' => 'required',
        ]);

        $data['quote'] = $request->quote;
        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;
        $data['user_id'] = $request->user_id;

        $id = Quotes::insert($data);

        return redirect()->back()->with('success_message', __('Quote has been added'));
    }

    function update($announcement_id = "", Request $request)
    {

        $this->validate($request, [
            'quote' => 'required|max:150',
            'from_date' => 'required',
            'to_date' => 'required',
            'user_id' => 'required',
        ]);

        $data['quote'] = $request->quote;
        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;
        $data['user_id'] = $request->user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $response = Quotes::where('id', $announcement_id)->update($data);


        if ($response) {
            return redirect()->back()->with('success_message', __('Quote data updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function delete($announcement_id = "")
    {
        Quotes::where('id', $announcement_id)->delete();
        return redirect()->back()->with('success_message', __('Quote deleted successfully'));
    }
}
