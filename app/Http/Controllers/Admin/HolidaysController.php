<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\{Holidays};

use Illuminate\Http\Request;

class HolidaysController extends Controller
{
    function index(){
        return view('admin.holidays.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255'
        ]);

        $data['name'] = $request->name;
        $data['date'] = $request->date;
        $data['optional'] = $request->optional ? 1 : 0;

        Holidays::insert($data);

        return redirect(route('admin.holidays'))->with('success_message', get_phrase('New holiday has been added'));
    }

    function update($id = "", Request $request){
        $data = [];
        $this->validate($request,[
            'name'=>'required|max:255'
        ]);

        $data['name'] = $request->name;
        $data['date'] = $request->date;
        $data['optional'] = $request->optional ? 1 : 0;

        Holidays::where('id', $id)->update($data);

        return redirect(route('admin.holidays'))->with('success_message', get_phrase('Holiday has been updated'));
    }

    function delete($id = ""){
        Holidays::where('id', $id)->delete();
        return redirect(route('admin.holidays'))->with('success_message', get_phrase('Holiday has been updated'));
    }
}