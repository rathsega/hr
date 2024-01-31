<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

use App\Models\{Branch};

use Illuminate\Http\Request;

class BranchController extends Controller
{
    function index(){
        return view('manager.branch.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Branch::insert($data);

        return redirect(route('manager.branch'))->with('success_message', get_phrase('New branch has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Branch::where('id', $id)->update($data);

        return redirect(route('manager.branch'))->with('success_message', get_phrase('Branch has been updated'));
    }

    function delete($id = ""){
        Branch::where('id', $id)->delete();
        return redirect(route('manager.branch'))->with('success_message', get_phrase('Branch has been updated'));
    }
}