<?php

namespace App\Http\Controllers\Manager;
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

        return ['sundays' => $sundays, 'saturdays' => $evenSaturdays];
    }

    function countSundaysAndSaturdays($startDate, $endDate) {
        $startDateTime = new \DateTime($startDate);
        $endDateTime = new \DateTime($endDate);
        
        $sundays = 0;
        $saturdays = 0;

        while ($startDateTime <= $endDateTime) {
            $dayOfWeek = $startDateTime->format('w'); // 0 (Sunday) to 6 (Saturday)
            
            if ($dayOfWeek == 0) { // Sunday
                $sundays++;
            } elseif ($dayOfWeek == 6) { // Even Saturday
                $saturdays += 1;
                
            }

            $startDateTime->modify('+1 day');
        }

        return ['sundays' => $sundays, 'saturdays' => $saturdays];
    }

    function getDaysInMonthForPeriod($startDate, $endDate, $year, $month) {
        $startDateObj = new \DateTime($startDate);
        $endDateObj = new \DateTime($endDate);
    
        $currentDate = clone $startDateObj;
        $totalDays = 0;
    
        while ($currentDate <= $endDateObj) {
            $currentYear = $currentDate->format('Y');
            $currentMonth = $currentDate->format('m');
    
            if ($currentYear == $year && $currentMonth == $month) {
                $totalDays += 1;
            }
    
            $currentDate->modify('+1 day');
        }
    
        return $totalDays;
    }

    function getDayOfTheWeekNumberByDate($date){
        $date_time = new \DateTime(date('Y-m-d', $date));
        return $date_time->format('w');// 0 (Sunday) to 6 (Saturday)
    }

    function getHalfdayHourLimitForLeave($date_time_stamp){
        if(date('N', $date_time_stamp) == 6){
            return 3;
        }else{
            return 4.5;
        }
    }

    function getHalfdayHourLimitForAttendance($date_time_stamp){
        if(date('N', $date_time_stamp) == 6){
            return 3;
        }else{
            return 4.5;
        }
    }

    function getFulldayHourLimitForAttendance($date_time_stamp){
        if(date('N', $date_time_stamp) == 6){
            return 6;
        }else{
            return 9;
        }
    }

    function getNumberOfLossffOfPayLeavesTakenByUser($selected_year, $selected_month, $user_id){
        $days = cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
        $from_date = strtotime($selected_year . '-' . $selected_month . '-1 00:00:00');
        $to_date = strtotime($selected_year .'-' . $selected_month. '-' . $days .' 23:59:59');
        $loss_of_pays = Leave_application::where('user_id', $user_id)->where('from_date','>=', $from_date)->where('to_date','<=', $to_date)->where('leave_type','loss_of_pay')->where('status', 'hr_approved')->get();
        $loss_of_pay_count = 0;
        if(!$loss_of_pays->isEmpty()){
            foreach($loss_of_pays as $loss_of_pay){
                $from_date = date('Y-m-d', $loss_of_pay->from_date);
                $to_date = date('Y-m-d', $loss_of_pay->to_date);
                if($from_date == $to_date){
                    $half_day_hours = $this->getHalfdayHourLimitForLeave($loss_of_pay->from_date);
                    if(($loss_of_pay->to_date - $loss_of_pay->from_date/3600) <= $half_day_hours){
                        $loss_of_pay_count += 0.5;
                    }else{
                        $loss_of_pay_count += 1;
                    }
                }else{
                    $loss_of_pay_count += $this->getDaysInMonthForPeriod($from_date, $to_date, $selected_year, $selected_month);
                }
                
            }
        }
        return $loss_of_pay_count;
    }

    function getNumberOfSickLeavesTakenByUser($selected_year, $selected_month, $user_id){
        $days = cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
        $from_date = strtotime($selected_year . '-' . $selected_month . '-1 00:00:00');
        $to_date = strtotime($selected_year .'-' . $selected_month. '-' . $days .' 23:59:59');
        $sick_leaves = Leave_application::where('user_id', $user_id)->where('from_date','>=', $from_date)->where('to_date','<=', $to_date)->where('leave_type','sick_leave')->where('status', 'hr_approved')->get();
        $sick_leave_count = 0;
        if(!$sick_leaves->isEmpty()){
            foreach($sick_leaves as $sick_leave){
                $from_date = date('Y-m-d', $sick_leave->from_date);
                $to_date = date('Y-m-d', $sick_leave->to_date);
                if($from_date == $to_date){
                    $half_day_hours = $this->getHalfdayHourLimitForLeave($sick_leave->from_date);
                    if(($sick_leave->to_date - $sick_leave->from_date)/3600 <= $half_day_hours){
                        $sick_leave_count += 0.5;
                    }else{
                        $sick_leave_count += 1;
                    }
                }else{
                    $sick_leave_count += $this->getDaysInMonthForPeriod($from_date, $to_date, $selected_year, $selected_month);
                }
            }
        }
        return $sick_leave_count;
    }

    function getNumberOfCasualLeavesTakenByUser($selected_year, $selected_month, $user_id){
        $days = cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
        $from_date = strtotime($selected_year . '-' . $selected_month . '-1 00:00:00');
        $to_date = strtotime($selected_year .'-' . $selected_month. '-' . $days .' 23:59:59');
        $casual_leaves = Leave_application::where('user_id', $user_id)->where('from_date','>=', $from_date)->where('to_date','<=', $to_date)->where('leave_type','casual_leave')->where('status', 'hr_approved')->get();
        $casual_leave_count = 0;
        if(!$casual_leaves->isEmpty()){
            foreach($casual_leaves as $casual_leave){
                $from_date = date('Y-m-d', $casual_leave->from_date);
                $to_date = date('Y-m-d', $casual_leave->to_date);
                if($from_date == $to_date){
                    $half_day_hours = $this->getHalfdayHourLimitForLeave($casual_leave->from_date);
                    if(($casual_leave->to_date - $casual_leave->from_date)/3600 <= $half_day_hours){
                        $casual_leave_count += 0.5;
                    }else{
                        $casual_leave_count += 1;
                    }
                }else{
                    $casual_leave_count += $this->getDaysInMonthForPeriod($from_date, $to_date, $selected_year, $selected_month);
                }
            }
        }
        return $casual_leave_count;
    }

    function isSaturdayEven($timestamp) {
        // Convert the date to a timestamp
    
        // Check if the day is Saturday
        if (date('l', $timestamp) === 'Saturday') {
            // Get the day of the month
            $dayOfMonth = date('j', $timestamp);
    
            // Check if the day of the month is even or odd
            if ($dayOfMonth % 2 == 0) {
                return "Saturday is even.";
            } else {
                return "Saturday is odd.";
            }
        } else {
            return "Not a Saturday.";
        }
    }

    function getNumberOfWorkedDays($user_id, $selected_year, $selected_month, $billing_type, $holidays_list){
        $days = cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
        $from_date = strtotime($selected_year . '-' . $selected_month . '-1 00:00:00');
        $to_date = strtotime($selected_year .'-' . $selected_month. '-' . $days .' 23:59:59');
        $worked_days = Attendance::where('user_id', $user_id)->where('checkin','>=', $from_date)->where('checkout','<=', $to_date)->get();
        $worked_days_count = 0;
        if(!$worked_days->isEmpty()){
            $holiday_dates = [];
            foreach($holidays_list as $holiday){
                $holiday_dates[] = date('Y-m-d', strtotime($holiday->date));
            }
            foreach($worked_days as $worked_day){
                if(date('l', $worked_day->checkin) == 'Sunday'){
                    continue;
                }
                if($billing_type == 'billable' && date('l', $worked_day->checkin) == 'Saturday'){
                    continue;
                }
                if(in_array( date('Y-m-d', $worked_day->checkin), $holiday_dates)){
                    continue;
                }

                $login = $worked_day->checkin;
                $logout = $worked_day->checkout;
                $hourdiff = ($logout - $login)/3600;
                $half_day_hours_limit = $this->getHalfdayHourLimitForAttendance($worked_day->checkin);
                $full_day_hours_limit = $this->getFulldayHourLimitForAttendance($worked_day->checkin);
                if($hourdiff >= $full_day_hours_limit){
                    $worked_days_count += 1;
                }else if($hourdiff >= $half_day_hours_limit){
                    $worked_days_count += 0.5;
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
            
            
            //Calculate number of working days
            $holidays_list = Holidays::orderBy('name')->get();
            
            
            foreach($active_users as $active_user){   
                //get number of days of the selected month
                $total_working_days=cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);             

                //Calculate days for the users who joined in the moddle of the month and who left in the end of the month
                $newly_joined = false;
                if(date("Y-m-d", strtotime($active_user->joining_date)) > date("Y-m-d", strtotime($selected_year .'-'.$selected_month.'-01')) && date("Y-m-d", strtotime($active_user->joining_date)) < date("Y-m-d", strtotime($selected_year .'-'.$selected_month.'-'. $total_working_days))){
                    $total_working_days = $total_working_days + 1 - date("d", strtotime($active_user->joining_date));
                    $newly_joined = true;
                }

                $relieved = false;
                if($active_user->relieving_date && date("Y-m-d", strtotime($active_user->relieving_date)) > date("Y-m-d", strtotime($selected_year .'-'.$selected_month.'-01')) && date("Y-m-d", strtotime($active_user->relieving_date)) < date("Y-m-d", strtotime($selected_year .'-'.$selected_month.'-'. $total_working_days)) && $newly_joined){
                    $total_working_days = date("d", strtotime($active_user->joining_date));
                    $relieved = true;
                }else if($active_user->relieving_date && date("Y-m-d", strtotime($active_user->relieving_date)) > date("Y-m-d", strtotime($selected_year .'-'.$selected_month.'-01')) && date("Y-m-d", strtotime($active_user->relieving_date)) < date("Y-m-d", strtotime($selected_year .'-'.$selected_month.'-'. $total_working_days))){
                    $total_working_days = date("d", strtotime($active_user->relieving_date)) + 1 - date("d", strtotime($active_user->joining_date));
                    $relieved = true;
                }

                if($newly_joined && !$relieved){
                    $from_date = date("Y-m-d", strtotime($active_user->joining_date));
                    $to_date = $selected_year . '-' . $selected_month .'-' . cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
                    $no_of_holidays = $this->numberOfHolidayExisted($holidays_list, $from_date, $to_date );
                }

                if(!$newly_joined && $relieved){
                    $from_date = $selected_year . '-' . $selected_month .'-1';
                    $to_date = date("Y-m-d", strtotime($active_user->relieving_date));
                    $no_of_holidays = $this->numberOfHolidayExisted($holidays_list, $from_date, $to_date );
                }

                if($newly_joined && $relieved){
                    $from_date = date("Y-m-d", strtotime($active_user->joining_date));
                    $to_date = date("Y-m-d", strtotime($active_user->relieving_date));
                    $no_of_holidays = $this->numberOfHolidayExisted($holidays_list, $from_date, $to_date );
                }

                if(!$newly_joined && !$relieved){
                    $from_date = $selected_year . '-' . $selected_month .'-1';
                    $to_date = $selected_year . '-' . $selected_month .'-' . cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year);
                    $no_of_holidays = $this->numberOfHolidayExisted($holidays_list, $from_date, $to_date );
                }


                if($active_user->billingtype == 'billable'){
                    $no_of_saturday_sunday = $this->countSundaysAndSaturdays($from_date, $to_date );
                }else{
                    $no_of_saturday_sunday = $this->countSundaysAndEvenSaturdays($from_date, $to_date );
                }


                $number_of_working_days = $total_working_days - $no_of_holidays - $no_of_saturday_sunday['sundays'] - $no_of_saturday_sunday['saturdays'];

                //Tally Days
                $number_of_attendancedays = $this->getNumberOfWorkedDays($active_user->id, $selected_year, $selected_month, $active_user->billingtype, $holidays_list);
                $loss_of_pay_days = $this->getNumberOfLossffOfPayLeavesTakenByUser($selected_year, $selected_month, $active_user->id); //$number_of_working_days - $number_of_attendancedays; - modification
                $sick_leave_days = $this->getNumberOfSickLeavesTakenByUser($selected_year, $selected_month, $active_user->id); //$number_of_working_days - $number_of_attendancedays; - modification
                $casual_leave_days = $this->getNumberOfCasualLeavesTakenByUser($selected_year, $selected_month, $active_user->id); //$number_of_working_days - $number_of_attendancedays; - modification
                
                //echo "Emp ID : " . $active_user->emp_id . "--- Newly : " . $newly_joined ."== Number Of Worked days :". $number_of_attendancedays . "=== Days : " . $total_working_days . "Saturdays : " . $no_of_saturday_sunday['saturdays'] . "== Sundays : " . $no_of_saturday_sunday['sundays'] . "===Holidays : ". $no_of_holidays . "</br>";


                if(!($number_of_attendancedays || $sick_leave_days || $casual_leave_days)){
                    continue;
                }
                //Check is payslip genearted for users for selected year and month
                $payslip = Payslip::where('user_id', $active_user->id)->whereDate('month_of_salary', $selected_year . '-' . $selected_month . '-1 00:00:00')->first();
                //if payslip is empty then generate payslip
                $salary_package = $active_user->salary_package;
                if($salary_package != null && $salary_package != 0){
                    if($active_user->employmenttype == 'full time'){
                        //calculate number of worked days
                        $actual_working_days = $number_of_attendancedays + $no_of_holidays + $no_of_saturday_sunday['sundays'] + $no_of_saturday_sunday['saturdays'] + $sick_leave_days + $casual_leave_days;
                        //$loss_of_pay_days = $total_working_days - $actual_working_days;
                        if(($number_of_attendancedays + $no_of_holidays + $no_of_saturday_sunday['sundays'] + $no_of_saturday_sunday['saturdays'] + $sick_leave_days + $casual_leave_days + $loss_of_pay_days) != $total_working_days){
                            if(($number_of_attendancedays + $no_of_holidays + $no_of_saturday_sunday['sundays'] + $no_of_saturday_sunday['saturdays'] + $sick_leave_days + $casual_leave_days + $loss_of_pay_days) < $total_working_days){
                                $loss_of_pay_days += ($total_working_days - ($number_of_attendancedays + $no_of_holidays + $no_of_saturday_sunday['sundays'] + $no_of_saturday_sunday['saturdays'] + $sick_leave_days + $casual_leave_days + $loss_of_pay_days));
                            }else{
                                $actual_working_days -= (($number_of_attendancedays + $no_of_holidays + $no_of_saturday_sunday['sundays'] + $no_of_saturday_sunday['saturdays'] + $sick_leave_days + $casual_leave_days + $loss_of_pay_days) - $total_working_days);
                            }
                        }
                        //calculate payable amount                    
                        $monthly_salary_amount = floor($salary_package);
                        $earned_salary = $actual_working_days * ($monthly_salary_amount/cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year));

                        //echo "user id : " . $active_user->emp_id . "--- actual working days : " . $actual_working_days . "-- Number of Working days : " . $number_of_working_days . " -- Number of Worked days : " . $number_of_attendancedays. " -- Number of LOP days : " . $loss_of_pay_days. " -- Number of Sick days : " . $sick_leave_days. " -- Number of Casual days : " . $casual_leave_days . '</br>';

                        //calculate salary component wise

                        //Basic 50% on Earned Salary.(after LOP).
                        $basic = floor($earned_salary/2);
                        //HRA 20%
                        $hra = floor($earned_salary/5);
                        //Conveyance : Earned >=50000,1600,IF(Earned salary >25000,800,0)
                        if($monthly_salary_amount >= 50000){
                            $conveyance = 1600;
                        }else if($monthly_salary_amount > 25000){
                            $conveyance = 800;
                        }else{
                            $conveyance = 0;
                        }
                        //Medical : 1250
                        $medical = 1250;
                        //LTA 5% on Earned Salary.
                        $lta = floor($earned_salary/20);
                        
                        //Education Allowances : IF(Earned Salary >50000,100*2,0).
                        if($earned_salary > 50000){
                            $education_allowance = 200;
                        }else{
                            $education_allowance = 0;
                        }

                        //Statutory Bonus : 11500 Per year, it will calculate on actual working days.
                        $statutory_bonus = floor(((11500/12)/cal_days_in_month(CAL_GREGORIAN,$selected_month,$selected_year)) * $actual_working_days);
                        
                        //PF : (IF(Basic >15000, (15000*12%), (Basic*12%)),0)
                        if($basic > 15000){
                            $pf = 1800;
                        }else{
                            $pf = floor(($basic/100)*12);
                        }
                        
                        
                        //(01-Apr-23 , 31-Aug-23)
                        // Gratuity : (Basic salary/26 *15)/12
                        if(($selected_year == 2024 && $selected_month <= 3) || ($selected_year == 2023 && $selected_month >= 4)){
                            if( date('Y-m-d', strtotime($active_user->joining_date)) <= date('Y-m-d', strtotime('2023-08-31' ))){
                                $gratuity = 0;
                            }else{
                                $gratuity = floor((($basic/26)*15)/12);
                            }
                        }else{
                            $gratuity = floor((($basic/26)*15)/12);
                        }

                        //Special Allowances : Balance amount adjusted.
                        //$except_basic_and_hra = $conveyance + $medical + $lta + $education_allowance + $statutory_bonus + $pf + $employee_esi  + $pt + $gratuity;
                        $total_earnings_except_esi = $basic + $hra + $conveyance + $medical + $lta + $education_allowance + $statutory_bonus + $pf  + $gratuity;
                        $special_allowance = $earned_salary - $total_earnings_except_esi;
                        $special_allowance = ceil($special_allowance);
                        if($special_allowance < 0){
                            $special_allowance = 0;
                            $earned_salary += abs($special_allowance);
                        }

                        $gross_salary = floor($basic + $hra + $conveyance + $medical + $lta + $education_allowance + $special_allowance);

                        // ESI : IF(Total Earnings<=21000,(gross*0.75%),0)
                        $total_earnings = floor($gross_salary + $statutory_bonus);
                        if($monthly_salary_amount <= 21000){
                            if($monthly_salary_amount <= 21000){
                                $employee_esi = floor($total_earnings*0.0075);
                                $employer_esi = floor($total_earnings*0.0325);
                            }else{
                                $employee_esi = 0;
                                $employer_esi = 0;
                            }
                        }else{
                            $employee_esi = 0;
                            $employer_esi = 0;
                        }

                        // PT : IF(Total Earnings >20000,200,IF(Gross>15000,150,0))
                        if($total_earnings > 20000){
                            $pt = 200;
                        }else if($total_earnings > 15000){
                            $pt = 150;
                        }else{
                            $pt = 0;
                        }

                        $total_deduction = floor($pf + $pt + $employee_esi);
                        $net_salary = floor($total_earnings - $total_deduction);
                        

                        $data = [];
                        $data['payroll_year'] = $selected_year;
                        $data['payroll_month'] = $selected_month;
                        $data['workingdays'] = $total_working_days - $loss_of_pay_days;
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

                        $data['deductions'] = $total_deduction;
                        $data['total_earnings'] = $total_earnings;
                        $data['net_salary'] = $net_salary;
                        $data['gross_salary'] = floor($gross_salary);
                        $data['tds'] = 0;

                    }else if($active_user->employmenttype == 'contract'){
                        //calculate payable amount                    
                        $actual_working_days = $number_of_attendancedays + $no_of_holidays + $no_of_saturday_sunday['sundays'] + $no_of_saturday_sunday['saturdays'] + $sick_leave_days + $casual_leave_days;
                        $loss_of_pay_days = $total_working_days - $actual_working_days;
                        //calculate payable amount                    
                        $monthly_salary_amount = floor($salary_package);
                        $earned_salary = $actual_working_days * ($monthly_salary_amount/$total_working_days);

                        //echo "cont user id : " . $active_user->emp_id . " === Newly Joined : " . $newly_joined." -----Relieved : " . $relieved ." --days :". $total_working_days ."--- Payable days : " . $actual_working_days . "-- Number of Working days : " . $number_of_working_days . " -- Number of Worked days : " . $number_of_attendancedays. " -- Number of LOP days : " . $loss_of_pay_days. " -- Number of Sick days : " . $sick_leave_days. " -- Number of Casual days : " . $casual_leave_days . '</br>';

                        $data = [];
                        $data['payroll_year'] = $selected_year;
                        $data['payroll_month'] = $selected_month;
                        $data['workingdays'] = $total_working_days - $loss_of_pay_days;
                        $data['loss_of_pay'] = $loss_of_pay_days;
                        $data['basic'] = 0;
                        $data['hra'] = 0;
                        $data['conveyance'] = 0;
                        $data['medical'] = 0;
                        $data['lta'] = 0;
                        $data['education_allowance'] = 0;
                        $data['statutory_bonus'] = 0;
                        $data['pf'] = 0;
                        $data['employee_esi'] = 0;
                        $data['employer_esi'] = 0;
                        $data['pt'] = 0;
                        $data['gratuity'] = 0;
                        $data['special_allowance'] = 0;
                        $data['user_id'] = $active_user->id;
                        $data['month_of_salary'] = date('Y-m-d 00:00:00', strtotime($selected_year.'-'.$selected_month.'-01'));
                        $data['total_earnings'] = $data['gross_salary'] = floor($earned_salary);
                        $data['tds'] = $data['deductions']  = floor(($earned_salary/100)*10);
                        $data['net_salary'] = floor($earned_salary) - floor(($earned_salary/100)*10);
                    }
                    if($number_of_working_days > $loss_of_pay_days){
                        if(empty($payslip) ){
                            Payslip::insert($data);
                        }else{
                            Payslip::where('id', $payslip->id)->update($data);
                        }
                    }
                    
                }
            }//exit;
        }
        return redirect()->back()->with('success_message', __('successfully'));
    }

    public function configure_extra_modules(){

    }
    

}