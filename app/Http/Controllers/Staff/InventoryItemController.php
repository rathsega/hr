<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Models\{Inventory, Inventory_item, FileUploader};

use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    function index(Request $request){
        return view('staff.inventory_item.index');
    }
}