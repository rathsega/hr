<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Announcements};


class AnnouncementsController extends Controller
{
    function index(){
        $page_data = [];
        $page_data['announcements'] = DB::select("SELECT a.id, a.subject, a.message, d.title, a.updated_at, a.status, a.notification AS department_name FROM announcements AS a LEFT JOIN departments AS d ON a.department = d.id LEFT JOIN users AS u ON u.department = d.id or a.department is null WHERE
        u.id = ". auth()->user()->id ." and a.notification=0");
        return view(auth()->user()->role.'.announcements.index', $page_data);
    }

    

}