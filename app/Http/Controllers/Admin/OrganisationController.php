<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\{User};
use Session;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class OrganisationController extends Controller
{

    function index(){

        // $page_data['active_staffs'] = User::where('status', 'active')->orderBy('sort')->get();
        /*$table =  DB::table("users as u")
        ->join("reportingstructure as rs", function($join){
            $join->on("u.manager", "=", "rs.id");
        })
        ->select("u.id", "u.name", "u.manager", "rs.level + 1")
        ->where("id,", "name,", "manager",);
        
        $users = DB::table("users")
        ->select("id", "name", "manager", "0 as level")
        ->whereNull("manager")
        ->union($table)
        ->get();*/

        $all_users_structure = DB::select("WITH RECURSIVE ReportingStructure AS (
            SELECT id, name, photo, designation, 0 AS manager, 1 AS level
            FROM users
            WHERE manager = 0   -- Assuming root employees have NULL in the manager column
          
            UNION ALL
          
            SELECT u.id, u.name, u.photo, u.designation, u.manager, rs.level + 1
            FROM users u
            JOIN ReportingStructure rs ON u.manager = rs.id
          )
          
          SELECT id, manager as parent, case when photo is null then CONCAT('<img src=/hr/public/uploads/user-image/placeholder/placeholder.png></br> ', name,'<p class=designation>(',designation,')</p>') else CONCAT('<img src=/hr/public/uploads/user-image/', photo,'></br> ', name,'<p class=designation>(',designation,')</p>') end as name 
          FROM ReportingStructure");
        
        $data = (array)$all_users_structure;
        //var_dump($data);exit;
        //$page_data['all_users_structure'][0] = array('id'=> null, 'name'=> '', 'parent'=> 0);
        foreach($data as $key => $val){
            if($val->parent == 0){
                $data[$key]->parent = 9999999;
            }
        }
        array_unshift($data, array('id'=> 9999999, 'name'=> '<img class="first-node" src=/hr/public/assets/images/zettamine-logo.png><p class=designation>Zettamine</p>', 'parent'=> 0));

        $page_data['all_users_structure'] = $data;

        $page_data['single_structure'] = DB::select("WITH RECURSIVE EmployeeStructure AS ( SELECT id, name, manager, photo FROM users WHERE id = ". auth()->user()->id ." UNION ALL SELECT u.id, u.name, u.manager, u.photo FROM users u JOIN EmployeeStructure es ON u.id = es.manager ) SELECT id, case when photo is null then CONCAT('<img src=/hr/public/uploads/user-image/placeholder/placeholder.png></br> ', name) else CONCAT('<img src=/hr/public/uploads/user-image/', photo,'></br> ', name) end as name ,case when manager is NULL THEN 0 ELSE manager END as parent FROM EmployeeStructure");
        
        $page_data['all_users'] = User::where('status', 'active')->orderBy('sort')->get();
        
        return view(auth()->user()->role.'.organisation.index', $page_data);
    }

    

}