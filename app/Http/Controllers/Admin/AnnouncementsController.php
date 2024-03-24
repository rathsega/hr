<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Announcements, User};
use Illuminate\Support\Facades\Hash;
use Mail;

class AnnouncementsController extends Controller
{
    function index()
    {
        $page_data = [];
        $page_data['announcements'] = DB::select("SELECT a.id, a.subject, a.message, d.title, a.updated_at, a.status, a.notification AS department_name FROM announcements AS a LEFT JOIN departments AS d ON a.department = d.id;");
        return view(auth()->user()->role . '.announcements.index', $page_data);
    }

    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890.$#%!@&*()-_+/{}[]<>';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'message' => 'required'
        ]);

        $data['subject'] = $request->subject;
        $data['message'] = $request->message;
        $data['department'] = $request->department;
        $data['notification'] = $request->notification == 'on' ? 1 : 0;

        $id = Announcements::insert($data);

        if ($data['notification']) {
            ini_set('max_execution_time', 1000);
            if ($data['department']) {
                $users = User::where('status', 'active')->where('department', $data['department'])->whereIn('role', array('staff', 'manager'))->get();
            } else {
                $users = User::where('status', 'active')->whereIn('role', array('staff', 'manager'))->get();
            }

            foreach ($users as $to) {
                if ($to->email/* == 'manikandan.m@zettamine.com' || $to->email == 'sekhar.r@zettamine.com'*/) {
                    $message = $request->message;
                    $subject = $request->subject;
                    $message = str_replace('{name}', $to->name, $message);
                    if (str_contains($message, '{password}')) {
                        $password = $this->randomPassword();
                        $message = str_replace('{password}', $password, $message);
                        $data = [];
                        $data['password'] = Hash::make($password);
                        $response = User::where('id', $to->id)->update($data);
                    }
                    try {
                        \Mail::raw($message, function ($message) use ($subject, $to) {
                            $message->from(get_settings('system_email'), get_settings('website_title'))
                                ->to($to->email, $to->name)
                                ->subject($subject);
                        });
                    } catch (\Exception $e) {
                        \Log::error('Email sending failed: ' . $e->getMessage());
                    }
                }
            }
        }

        return redirect()->back()->with('success_message', __('Announcement has been added'));
    }

    function update($announcement_id = "", Request $request)
    {

        $this->validate($request, [
            'subject' => 'required',
            'message' => 'required'
        ]);

        $data['subject'] = $request->subject;
        $data['message'] = $request->message;
        $data['department'] = $request->department;
        $data['notification'] = $request->notification == 'on' ? 1 : 0;
        $data['updated_at'] = date('Y-m-d H:i:s');


        $response = Announcements::where('id', $announcement_id)->update($data);


        if ($response) {
            return redirect()->back()->with('success_message', __('Announcement data updated successfully'));
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    function delete($announcement_id = "")
    {
        Announcements::where('id', $announcement_id)->delete();
        return redirect()->back()->with('success_message', __('Announcement deleted successfully'));
    }
}
