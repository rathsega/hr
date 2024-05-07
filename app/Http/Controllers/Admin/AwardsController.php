<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{EmployeeOfTheMonth, User};

class AwardsController extends Controller
{
    function eotm()
    {
        $page_data['title'] = "Employee Of The Month";
        return view(auth()->user()->role . '.awards.eotm.index', $page_data);
    }
    function eotq()
    {
        $page_data['title'] = "Employee Of The Quarter";
        return view(auth()->user()->role . '.awards.eotq.index', $page_data);
    }
    function eoty()
    {
        $page_data['title'] = "Employee Of The Year";
        return view(auth()->user()->role . '.awards.eoty.index', $page_data);
    }
    function lse()
    {
        $page_data['title'] = "Long Service Employee";
        return view(auth()->user()->role . '.awards.lse.index', $page_data);
    }
}
