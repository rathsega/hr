<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $current_date = date('Y-m-d');
        $birthday_users = DB::select("SELECT name, photo FROM users WHERE DATE_FORMAT(actual_birthday, '%m-%d') = DATE_FORMAT('$current_date', '%m-%d') and status='active'");
        $today_quote = DB::select("SELECT q.*, u.id as user_id, u.name, u.designation, u.photo from quotes as q inner join users as u on u.id = q.user_id WHERE DATE(q.from_date) <= CURDATE() and DATE(q.to_date) >= CURDATE()");
        $employee_of_the_month = DB::select("select e.*, e.id as id, u.id as user_id, u.name, u.photo, u.designation, u.emp_id, u.email from employee_of_the_month as e inner join users as u on u.id = e.user_id WHERE e.month = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
        AND e.year = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)");
        $announcements = DB::select("SELECT a.id, a.subject, a.message FROM announcements AS a where a.notification=0 and  DATE(a.from_date) <= CURDATE() and DATE(a.to_date) >= CURDATE()");

        $data = [];

        if($birthday_users){
            foreach($birthday_users as $key => $birthday_user){
                $slider = [];
                $slider['type'] = "birthday";
                $slider['name'] = $birthday_user->name;
                $slider['photo'] = $birthday_user->photo;
                $data[] = $slider;
            }
        }

        if($today_quote){
            foreach($today_quote as $key => $quote){
                $slider = [];
                $slider['type'] = "quote";
                $slider['name'] = $quote->name;
                $slider['photo'] = $quote->photo;
                $slider['quote'] = $quote->quote;
                $slider['designation'] = $quote->designation;
                $data[] = $slider;
            }
        }
        if($employee_of_the_month){
            foreach($employee_of_the_month as $key => $employee){
                $slider = [];
                $slider['type'] = "eotm";
                $slider['name'] = $employee->name;
                $slider['photo'] = $employee->photo;
                $slider['designation'] = $employee->designation;
                $data[] = $slider;
            }
        }
        if($announcements){
            foreach($announcements as $key => $announcement){
                $slider = [];
                $slider['type'] = "announcement";
                $slider['subject'] = $announcement->subject;
                $slider['message'] = $announcement->message;
                $data[] = $slider;
            }
        }
        return view('auth.login', array('slides'=>$data));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
