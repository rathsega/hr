<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class BirthdaysController extends Controller
{
    function index(){
        return view('admin.birthdays.index');
    }
    
}