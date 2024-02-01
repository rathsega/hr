<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Models\{Holidays};

use Illuminate\Http\Request;

class HolidaysController extends Controller
{
    function index(){
        return view(auth()->user()->role.'.holidays.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Holidays::insert($data);

        return redirect(route(auth()->user()->role.'.holidays'))->with('success_message', get_phrase('New holiday has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Holidays::where('id', $id)->update($data);

        return redirect(route(auth()->user()->role.'.holidays'))->with('success_message', get_phrase('Holidays has been updated'));
    }

    function delete($id = ""){
        Holidays::where('id', $id)->delete();
        return redirect(route(auth()->user()->role.'.holidays'))->with('success_message', get_phrase('Holidays has been updated'));
    }
}