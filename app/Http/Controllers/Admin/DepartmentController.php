<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\{Department};

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function index(){
        return view('admin.department.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Department::insert($data);

        return redirect(route('admin.department'))->with('success_message', get_phrase('New department has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Department::where('id', $id)->update($data);

        return redirect(route('admin.department'))->with('success_message', get_phrase('Department has been updated'));
    }

    function delete($id = ""){
        Department::where('id', $id)->delete();
        return redirect(route('admin.department'))->with('success_message', get_phrase('Department has been updated'));
    }
}