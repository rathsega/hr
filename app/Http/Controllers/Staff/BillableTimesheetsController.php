<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Models\{Billable_timesheets};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BillableTimesheetsController extends Controller
{
    function index(){
        return view('staff.billabletimesheet.index');
    }

    function store(Request $request){
        $this->validate($request,[
            'from_date'=>'required',
            'to_date'=>'required',
            'leave_dates'=>'required|max:250'
        ]);

        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;
        $data['leave_dates'] = $request->leave_dates;
        $data['updated_at'] = date("Y-m-d");
        $data['user_id'] = auth()->user()->id;
        $directory = 'public/uploads/billabletimesheets/';
        if($request->hasFile('file')){
            // Validate the file
            $validatedData = $request->validate([
                'file' => 'required|file|max:1024' // For example, maximum 2MB
            ]);
            $file = $request->file('file');
            $data['timesheet'] = random(20).'.'.$file->extension();

            if (!Storage::disk('local')->exists($directory)) {
                Storage::disk('local')->makeDirectory($directory);
            }
            move_uploaded_file($_FILES["file"]["tmp_name"],$directory.$data['timesheet']);
        }

        Billable_timesheets::insert($data);

        return redirect(route('staff.billabletimesheet'))->with('success_message', get_phrase('New timesheet has been added'));
    }

    function update($id = "", $timesheet, Request $request){
        $this->validate($request,[
            'from_date'=>'required',
            'to_date'=>'required',
            'leave_dates'=>'required|max:250'
        ]);

        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;
        $data['leave_dates'] = $request->leave_dates;
        $data['updated_at'] = date("Y-m-d");
        $data['user_id'] = auth()->user()->id;
        $directory = 'public/uploads/billabletimesheets/';
        if($request->hasFile('file')){
            // Validate the file
            $validatedData = $request->validate([
                'file' => 'required|file|max:1024' // For example, maximum 2MB
            ]);
            $file = $request->file('file');
            $data['timesheet'] = random(20).'.'.$file->extension();

            if (!Storage::disk('local')->exists($directory)) {
                Storage::disk('local')->makeDirectory($directory);
            }
            move_uploaded_file($_FILES["file"]["tmp_name"],$directory.$data['timesheet']);
            unlink($directory . $timesheet);
        }

        Billable_timesheets::where('id', $id)->update($data);

        return redirect(route('staff.billabletimesheet'))->with('success_message', get_phrase('Timesheet has been updated'));
    }

    function delete($id = ""){
        Billable_timesheets::where('id', $id)->delete();
        return redirect(route('staff.billabletimesheet'))->with('success_message', get_phrase('Timesheet has been deleted'));
    }

    function download($id = ""){
        $timesheet = Billable_timesheets::where('id', $id)->first();
        // Define the file's path
        $filePath = 'public/uploads/billabletimesheets/' . $timesheet->timesheet;

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Download the file
        response()->download($filePath);
        return redirect(route('staff.billabletimesheet'))->with('success_message', get_phrase('Timesheet has been downloaded'));
    }
}