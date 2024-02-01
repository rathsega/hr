<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;

class BirthdaysController extends Controller
{
    function index(){
        return view('admin.birthdays.index');
    }
    
}