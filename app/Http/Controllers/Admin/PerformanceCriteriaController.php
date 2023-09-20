<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Performance_type;
use Illuminate\Http\Request;

class PerformanceCriteriaController extends Controller
{
    function index(){
        return view('admin.performance_criteria.index');
    }

    function store(Request $request){

        $this->validate($request, [
            'title' => 'required'
        ]);

        $data['title'] = $request->title;
        $data['slug'] = slugify($request->title);
        $data['description'] = slugify($request->description);

        Performance_type::insert($data);
        return redirect()->back()->with('success_message', get_phrase('Performance criteria has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request, [
            'title' => 'required'
        ]);

        $data['title'] = $request->title;
        $data['slug'] = slugify($request->title);
        $data['description'] = slugify($request->description);

        Performance_type::where('id', $id)->update($data);
        return redirect()->back()->with('success_message', get_phrase('Performance criteria has been updated'));
    }

    function delete($id = ""){
        Performance_type::where('id', $id)->delete();
        return redirect()->back()->with('success_message', get_phrase('Performance criteria has been deleted'));
    }
}
