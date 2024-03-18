<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

use App\Models\{Inventory, Inventory_item, FileUploader};

use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    function index(Request $request){
        $page_data['inventory'] = Inventory::where('id', $request->item_type)->first();
        return view('manager.inventory_item.index', $page_data);
    }

    function store(Request $request){
        $this->validate($request,[
            'branch_id'=>'required',
            'type_id' => 'required',
            'name'=>'required|max:255',
            'photo'=>'image',
        ]);

        $data['branch_id'] = $request->branch_id;
        $data['type_id'] = $request->type_id;
        $data['assigned_user_id'] = $request->assigned_user_id;
        $data['responsible_user_id'] = $request->responsible_user_id;
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        if($request->photo){
            $data['photo'] = FileUploader::upload($request->photo, 'uploads/inventory-item', 1000, null, 100);
        }

        $id = Inventory_item::insertGetId($data);

        $title_of_item_type = Inventory::where('id', $request->type_id)->first()->title;
        $identifier = strtoupper(substr($title_of_item_type,0,3).'-'.$id);
        Inventory_item::where('id', $id)->update(['identification' => $identifier]);

        return redirect()->back()->with('success_message', get_phrase('New inventory item has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'branch_id'=>'required',
            'type_id' => 'required',
            'name'=>'required|max:255',
            'photo'=>'image',
        ]);

        $data['branch_id'] = $request->branch_id;
        $data['type_id'] = $request->type_id;
        $data['assigned_user_id'] = $request->assigned_user_id;
        $data['responsible_user_id'] = $request->responsible_user_id;
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        $title_of_item_type = Inventory::where('id', $request->type_id)->first()->title;
        $identifier = strtoupper(substr($title_of_item_type,0,3).'-'.$id);
        $data['identification'] = $identifier;

        if($request->photo){
            remove_file(Inventory_item::find($id)->photo);
            $data['photo'] = FileUploader::upload($request->photo, 'uploads/inventory-item', 1000, null, 100);
        }

        Inventory_item::where('id', $id)->update($data);

        return redirect()->back()->with('success_message', get_phrase('Inventory item has been updated'));
    }

    function delete($id = ""){
        remove_file(Inventory_item::find($id)->photo);
        Inventory_item::where('id', $id)->delete();
        return redirect()->back()->with('success_message', get_phrase('Inventory item has been deleted'));
    }
}