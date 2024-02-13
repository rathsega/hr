<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\{User, Payslip, Holidays, Leaves_count, Leave_application, Attendance};

class PayrollConfigurationController extends Controller
{

    function index(){

        
        $page_data['title'] = "Payroll Configuration";

        //get all active employee

        /**
         * Calculate Number of days of payroll month
         * 
         * Calculate number of working days
         * ->Number of days - Number Of Sundays - Number of Even Saturdays - Number Of Holidays
         * 
         * Calculate number of worked days
         * ->Number of Working days- Number of Leaves
         * 
         * 
         */
        
        return view(auth()->user()->role.'.payrollconfiguration.index', $page_data);
    }

    function store(Request $request){
        $request->validate([
            'users' => 'required|mimes:xlsx,xls',
        ]);

        $path = $request->file('users')->getRealPath();

            // Use Laravel Excel to import data
        $data = [];
        return redirect()->back()->with('success_message', __('successfully'));
    }

    function numberOfHolidayExisted($holidays_list, $from_date, $to_date){
        $no_of_holidays = 0;
        foreach($holidays_list as $holiday){
            if ((date('Y-m-d', strtotime($holiday->date)) >= date('Y-m-d', strtotime($from_date))) && (date('Y-m-d', strtotime($holiday->date)) <= date('Y-m-d', strtotime($to_date))) && !$holiday->optional){
                $no_of_holidays += 1;
            }
        }

        return (int)$no_of_holidays;

    }
    
    function countSundaysAndEvenSaturdays($startDate, $endDate) {
        $startDateTime = new \DateTime($startDate);
        $endDateTime = new \DateTime($endDate);
        
        $sundays = 0;
        $evenSaturdays = 0;

        while ($startDateTime <= $endDateTime) {
            $dayOfWeek = $startDateTime->format('w'); // 0 (Sunday) to 6 (Saturday)
            
            if ($dayOfWeek == 0) { // Sunday
                $sundays++;
            } elseif ($dayOfWeek == 6) { // Even Saturday
                $dayOfMonth = $startDateTime->format('d');
                $weekNum = ceil($dayOfMonth / 7);
                if ($weekNum % 2 == 0) { //check that the week number is even
                    $evenSaturdays += 1;
                }
                
            }

            $startDateTime->modify('+1 day');
        }

        return ['sundays' => $sundays, 'evenSaturdays' => $evenSaturdays];
    }

    /*function getNumberOfLeavesTakenByUser($year, $month, $days){
        $from_date = strtotime($year . '-' . $month . '-1 00:00:00');
        $to_date = strtotime($year .'-' . $month. '-' . $days .' 23:59:59');
        $loss_of_pay = Leave_application::where('user_id', auth()->user()->id)->where('from_date>=', $from_date)->where('to_date>=', $to_date)->where('leave_type','loss_of_pay')->where('leave_applications.status', 'hr_approved')->get();
          
    }*/

    function getNumberOfWorkedDays($user_id, $selected_year, $selected_month, $days){
        $from_date = strtotime($selected_year . '-' . $selected_month . '-1 00:00:00');
        $to_date = strtotime($selected_year .'-' . $selected_month. '-' . $days .' 23:59:59');
        $worked_days = Attendance::where('user_id', $user_id)->where('checkin','>=', $from_date)->where('checkout','<=', $to_date)->get();
        $worked_days_count = 0;
        if(!$worked_days->isEmpty()){
            foreach($worked_days as $worked_day){
                $login = $worked_day->checkin;
                $logout = $worked_day->checkout;
                $hourdiff = ($logout - $login)/3600;
                if($hourdiff >= 9){
                    $worked_days_count += 1;
                }
            }
        }
        return $worked_days_count;
    }

    function getNumberOfdaysInaYear($year){
        // Loop through each month to get the number of days
        $totalDays = 0;
        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $totalDays += $daysInMonth;
        }
        return $totalDays;
    }

    function isDateInFinancialYearFirstQuarter($date) {
        // Convert the input date to a DateTime object
        $dateTime = new \DateTime($date);
    
        // Get the current month and day
        $currentMonth = (int)date('m');
        $currentDay = (int)date('d');
    
        // Set the start date of the financial year (April 1st of the current year)
        $financialYearStart = new \DateTime(date('Y') . '-04-01');
    
        // Set the end date of the financial year (March 31st of the next year)
        $financialYearEnd = new \DateTime((date('Y')+1) . '-08-31');
    
        // Check if the date is between the start and end dates of the financial year
        if (($dateTime >= $financialYearStart && $dateTime <= $financialYearEnd) ||
            ($currentMonth >= 4 && $currentDay >= 1 && $dateTime <= $financialYearEnd)) {
            return true;
        } else {
            return false;
        }
    }

    function generate(Request $request){
        $selected_year = $request->year;
        $selected_month = $request->month;
        //echo $selected_year . '-' . $selected_month . '-1 00:00:00';exit;
        
        //get all active users
        $active_users = User::where('status', 'active')->whereIn('role', array('staff', 'manager'))->get();
        if(!$active_users->isEmpty()){
            
            //get number of days of the selected month
            $days=cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
            //Calculate number of working days
            $holidays_list = Holidays::orderBy('name')->get();
            $no_of_holidays = $this->numberOfHolidayExisted($holidays_list, $selected_year . '-' . $selected_month . '-1', $selected_year . '-' . $selected_month .'-' . $days );
            $no_of_saturday_sunday = $this->countSundaysAndEvenSaturdays($selected_year . '-' . $selected_month . '-1', $selected_year . '-' . $selected_month .'-' . $days );
            $number_of_working_days = $days - $no_of_holidays - $no_of_saturday_sunday['sundays'] - $no_of_saturday_sunday['evenSaturdays'];
            foreach($active_users as $active_user){
                //Check is payslip genearted for users for selected year and month
                $payslip = Payslip::where('user_id', $active_user->id)->whereDate('month_of_salary', $selected_year . '-' . $selected_month . '-1 00:00:00')->first();
                //if payslip is empty then generate payslip
                $salary_package = $active_user->salary_package;
                if($salary_package != null && $salary_package != 0){
                    if($active_user->employmenttype == 'full time'){
                        //calculate number of worked days
                        $number_of_worked_days = $this->getNumberOfWorkedDays($active_user->id, $selected_year, $selected_month, $days);
                        $loss_of_pay_days = $number_of_working_days - $number_of_worked_days;
                        $payable_days = $days - $loss_of_pay_days;

                        //calculate payable amount                    
                        $monthly_salary_amount = floor($salary_package/12);
                        $payable_amount = ($days - $loss_of_pay_days) * ($monthly_salary_amount/$days);

                        //calculate salary component wise

                        //Basic 50% on Earned Salary.(after LOP).
                        $basic = floor($payable_amount/2);
                        //HRA 20%
                        $hra = floor($payable_amount/5);
                        //Conveyance : Earned >=50000,1600,IF(Earned salary >25000,800,0)
                        if($payable_amount >= 50000){
                            $conveyance = 1600;
                        }else if($payable_amount > 25000){
                            $conveyance = 800;
                        }else{
                            $conveyance = 0;
                        }
                        //Medical : 1250
                        $medical = 1250;
                        //LTA 5% on Earned Salary.
                        $lta = floor($payable_amount/20);
                        
                        //Education Allowances : IF(Earned Salary >50000,100*2,0).
                        if($payable_amount > 50000){
                            $education_allowance = 200;
                        }else{
                            $education_allowance = 0;
                        }

                        //Statutory Bonus : 11500 Per year, it will calculate on actual working days.
                        $statutory_bonus = floor(((11500/12)/$days) * $payable_days);
                        
                        //PF : (IF(Basic >15000, (15000*12%), (Basic*12%)),0)
                        if($basic > 15000){
                            $pf = 1800;
                        }else{
                            $pf = floor(($basic/100)*12);
                        }
                        // ESI : IF(Total Earnings<=21000,(gross*0.75%),0)
                        if($payable_amount <= 21000){
                            $employee_esi = floor($payable_amount*0.75);
                            $employer_esi = floor($payable_amount*3.25);
                        }else{
                            $employee_esi = 0;
                            $employer_esi = 0;
                        }
                        // PT : IF(Total Earnings >20000,200,IF(Gross>15000,150,0))
                        if($payable_amount > 20000){
                            $pt = 200;
                        }else if($payable_amount > 15000){
                            $pt = 150;
                        }else{
                            $pt = 0;
                        }
                        //(01-Apr-23 , 31-Aug-23)
                        // Gratuity : (Basic salary/26 *15)/12
                        if(($selected_year == 2024 && $selected_month <= 3) || ($selected_year == 2023 && $selected_month >= 4)){
                            if( date('Y-m-d', strtotime($active_user->joined_date)) <= date('Y-m-d', strtotime('2023-08-31' ))){
                                $gratuity = 0;
                            }else{
                                $gratuity = floor((($basic/26)*15)/12);
                            }
                        }else{
                            $gratuity = floor((($basic/26)*15)/12);
                        }

                        //Special Allowances : Balance amount adjusted.
                        $except_basic_and_hra = $conveyance + $medical + $lta + $education_allowance + $statutory_bonus + $pf + $employee_esi + $employer_esi + $pt + $gratuity;
                        $total_earnings = $basic + $hra + $conveyance + $medical + $lta + $education_allowance + $pf + $employee_esi + $employer_esi + $gratuity;
                        $special_allowance = $payable_amount - $total_earnings;
                        $special_allowance = ceil($special_allowance);
                        $data = [];
                        $data['payroll_year'] = $selected_year;
                        $data['payroll_month'] = $selected_month;
                        $data['workingdays'] = $days;
                        $data['loss_of_pay'] = $loss_of_pay_days;
                        $data['basic'] = $basic;
                        $data['hra'] = $hra;
                        $data['conveyance'] = $conveyance;
                        $data['medical'] = $medical;
                        $data['lta'] = $lta;
                        $data['education_allowance'] = $education_allowance;
                        $data['statutory_bonus'] = $statutory_bonus;
                        $data['pf'] = $pf;
                        $data['employee_esi'] = $employee_esi;
                        $data['employer_esi'] = $employer_esi;
                        $data['pt'] = $pt;
                        $data['gratuity'] = $gratuity;
                        $data['special_allowance'] = $special_allowance;
                        $data['user_id'] = $active_user->id;
                        $data['month_of_salary'] = date('Y-m-d 00:00:00', strtotime($selected_year.'-'.$selected_month.'-01'));

                        $data['deductions'] = floor($pf + $pt + $employee_esi + $employer_esi);
                        $data['total_earnings'] = floor($basic + $hra + $conveyance + $medical + $lta + $education_allowance + $special_allowance);
                        $data['net_salary'] = floor($data['total_earnings'] - $data['deductions']);
                        $data['payable_amount'] = floor($payable_amount);
                        $data['tds'] = 0;

                    }else if($active_user->employmenttype == 'contract'){
                        //calculate number of worked days
                        $number_of_worked_days = $this->getNumberOfWorkedDays($active_user->id, $selected_year, $selected_month, $days);
                        $loss_of_pay_days = $number_of_working_days - $number_of_worked_days;
                        $payable_days = $days - $loss_of_pay_days;

                        //calculate payable amount                    
                        $monthly_salary_amount = floor($salary_package/12);
                        $payable_amount = ($days - $loss_of_pay_days) * ($monthly_salary_amount/$days);

                        $data['total_earnings'] = $data['payable_amount'] = floor($payable_amount);
                        $data['tds'] = $data['deductions']  = floor(($payable_amount/100)*10);
                        $data['net_salary'] = floor(($payable_amount/100)*10);
                    }
                    
                    if(empty($payslip) ){
                        Payslip::insert($data);
                    }else{
                        Payslip::where('id', $payslip->id)->update($data);
                    }
                }
            }
        }
        return redirect()->back()->with('success_message', __('successfully'));
    }
    

}