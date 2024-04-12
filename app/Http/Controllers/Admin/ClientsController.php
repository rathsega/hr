<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\{Clients};

use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Client;

class ClientsController extends Controller
{
    function index(){
        return view('admin.clients.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'name'=>'required|max:100',
            'reminder_type'=>'required',
        ]);

        $data['name'] = $request->name;
        $data['reminder_type'] = $request->reminder_type;
        $data['created_at'] = date('Y-m-d');
        $data['updated_at'] = date('Y-m-d');

        Clients::insert($data);

        return redirect(route('admin.clients'))->with('success_message', get_phrase('New client has been added'));
    }

    function update($id = "", Request $request){
        $this->validate($request,[
            'name'=>'required|max:100',
            'reminder_type'=>'required',
        ]);

        $data['updated_at'] = date('Y-m-d');
        $data['name'] = $request->name;
        $data['reminder_type'] = $request->reminder_type;

        Clients::where('id', $id)->update($data);

        return redirect(route('admin.clients'))->with('success_message', get_phrase('Client has been updated'));
    }

    function delete($id = ""){
        Clients::where('id', $id)->delete();
        return redirect(route('admin.clients'))->with('success_message', get_phrase('Client has been updated'));
    }
}