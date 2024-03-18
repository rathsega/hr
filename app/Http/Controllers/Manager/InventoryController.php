<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

use App\Models\Inventory;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function index(){
        return view('manager.inventory.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Inventory::insert($data);

        return redirect(route('manager.inventory'))->with('success_message', get_phrase('New inventory items type has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'title'=>'required|max:255'
        ]);

        $data['title'] = $request->title;
        $data['description'] = $request->description;

        Inventory::where('id', $id)->update($data);

        return redirect(route('manager.inventory'))->with('success_message', get_phrase('Inventory items type has been updated'));
    }

    function delete($id = ""){
        Inventory::where('id', $id)->delete();
        return redirect(route('manager.inventory'))->with('success_message', get_phrase('Inventory items type has been deleted'));
    }
}
