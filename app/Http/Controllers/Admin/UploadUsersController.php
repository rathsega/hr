<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\{User};
use Session;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelReader;

class UploadUsersController extends Controller
{

    function index(){

        
        $page_data['title'] = "Upload Users";
        
        return view(auth()->user()->role.'.uploadusers.index', $page_data);
    }

    function store(Request $request){
        $request->validate([
            'users' => 'required|mimes:xlsx,xls',
        ]);

        $path = $request->file('users')->getRealPath();

            // Use Laravel Excel to import data
        $data = [];
        Excel::import(new ExcelReader, $path);
        User::where('email', 'test@zettamine.com')->delete();
        return redirect()->back()->with('success_message', __('New staff added successfully'));
    }
    

}