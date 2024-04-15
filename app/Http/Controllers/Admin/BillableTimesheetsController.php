<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BillableTimesheetsController extends Controller
{
    function index(){
        $data = [];
        $data['title'] = "TImehseets";
        $data['timesheets'] = DB::select("SELECT u.name, u.emp_id, bt.* FROM `billable_timesheets` as bt inner join users as u on u.id = bt.user_id order by bt.id desc");
        return view('admin.billabletimesheet.index', $data);
    }

}