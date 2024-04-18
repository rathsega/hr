<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\{Clients, Reminder_logs};

use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Client;
use Illuminate\Support\Facades\DB;

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
        $data['updated_at'] = date('Y-m-d');
        $data['status'] = 'deleted';

        Clients::where('id', $id)->update($data);
        return redirect(route('admin.clients'))->with('success_message', get_phrase('Client has been deleted'));
    }

    function log($id=""){
        $data = [];
        if($id){
            $data['logs'] = DB::select("select r.*, u.name as employee, u.emp_id, u.email, c.name as client  from reminder_logs as r inner join users as u on u.id = r.user_id inner join clients as c on c.id = u.client where u.client =".$id);
        }else{
            $data['logs'] = DB::select("select r.*, u.name as employee, u.emp_id, u.email, c.name as client  from reminder_logs as r inner join users as u on u.id = r.user_id inner join clients as c on c.id = u.client");
        }

        $data['title'] = "Reminder Log";
        
        return view('admin.clients.log', $data);
    }
}