<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{

	function right_modal($view_path = "", Request $request)
	{
		$page_data = array();
		foreach ($request->all() as $key => $value) :
			$page_data[$key] = $value;
		endforeach;

		return view($view_path, $page_data);
	}
	
}
