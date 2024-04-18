<?php

namespace App\Exports;

use App\Models\{User, Leaves_count, Leave_application, Holidays};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LeaveBalanceExport implements FromCollection, WithHeadings
{

    var $from_date;
    var $to_date;
    public function __construct($from_date, $to_date)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    function numberOfHolidayExisted($holidays_list, $from_date, $to_date)
    {
        $no_of_holidays = 0;
        foreach ($holidays_list as $holiday) {
            if ((date('Y-m-d', strtotime($holiday->date)) >= date('Y-m-d', strtotime($from_date))) && (date('Y-m-d', strtotime($holiday->date)) <= date('Y-m-d', strtotime($to_date))) && !$holiday->optional) {
                $no_of_holidays += 1;
            }
        }

        return $no_of_holidays;
    }

    function countSundaysAndEvenSaturdays($startDate, $endDate)
    {
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

    function getHalfdayHourLimitForLeave($date_time_stamp)
    {
        if (date('N', $date_time_stamp) == 6) {
            return 3;
        } else {
            return 4.5;
        }
    }

    public function collection()
    {
        $export_data = [];
        $users = User::where('role', '!=', 'admin')->where('status', 'active')->orderBy('sort')->get();
        foreach ($users as $key => $user) {
            $export_data[$key] = [];
            $data = DB::select("SELECT u.name AS Name, u.emp_id, u.designation, u.phone, u.employmenttype, u.billingtype, u.joining_date, s.user_proposed_last_working_day, s.hr_proposed_last_working_day, s.actual_last_working_day from users as u right join separation as s on s.user_id = u.id where s.status = 'Relieved' and COALESCE(s.hr_proposed_last_working_day, s.user_proposed_last_working_day, s.actual_last_working_day) BETWEEN '" . $this->from_date . "' AND '" . $this->to_date . "' ");
            $carry_forwarded_leave_count = DB::table('carry_forwarded_leaves_count')->where('user_id', $user->id)->get();
            if (!$carry_forwarded_leave_count->isEmpty()) {
                $carry_forwarded_leave_count = $carry_forwarded_leave_count[0]->count;
            } else {
                $carry_forwarded_leave_count = 0;
            }
            $leaves_count = Leaves_count::get()->First();
            $sick_leaves = Leave_application::where('user_id', $user->id)->where('leave_type', 'sick_leave')->whereNotIn('leave_applications.status', ['hr_rejected', 'manager_rejected', 'cancelled'])->get();
            $casual_leaves = Leave_application::where('user_id', $user->id)->where('leave_type', 'casual_leave')->whereNotIn('leave_applications.status', ['hr_rejected', 'manager_rejected', 'cancelled'])->get();

            //check any holidays in the leave days
            $holidays_list = Holidays::orderBy('name')->get();


            //Calculate Sick Leave Count
            $sick_leave_count = 0;
            if (!$sick_leaves->isEmpty()) {
                foreach ($sick_leaves as $sick_leave) {
                    $from_year = date('Y', $sick_leave->from_date);
                    $from_date = date('Y-m-d', $sick_leave->from_date);
                    $to_year = date('Y', $sick_leave->to_date);
                    $to_date = date('Y-m-d', $sick_leave->to_date);
                    $current_year = date('Y');
                    if ($from_year == $current_year || $to_year == $current_year) {
                        if ($from_year == $current_year && $to_year == $current_year) {
                            $datediff = $sick_leave->to_date - $sick_leave->from_date;
                            if (date("Y-m-d", $sick_leave->from_date) == date("Y-m-d", $sick_leave->to_date)) {
                                $sick_leave_count += 1;
                            } else {
                                $sick_leave_count += (round($datediff / (60 * 60 * 24))) + 1;
                                $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date, $to_date);
                                $saturday_sunday = countSundaysAndEvenSaturdays($from_date, $to_date);
                                $sick_leave_count = $sick_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                            }
                        } else if ($from_year == $current_year && $to_year == $current_year + 1) {
                            $your_date = strtotime($from_date);
                            $datediff = strtotime($current_year . "-12-31") - $your_date;
                            $sick_leave_count += (round($datediff / (60 * 60 * 24))) + 1;
                            $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date, date(strtotime($current_year . "-12-31")));
                            $saturday_sunday = countSundaysAndEvenSaturdays($from_date, date('Y-m-d', strtotime($current_year . "-12-31")));
                            $sick_leave_count = $sick_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                        } else if ($from_year == $current_year - 1 && $to_year == $current_year) {
                            $your_date = strtotime($to_date);
                            $datediff = $your_date - strtotime($current_year . "-01-01");
                            $sick_leave_count += (round($datediff / (60 * 60 * 24))) + 1;
                            $no_of_holidays = numberOfHolidayExisted($holidays_list, date(strtotime($current_year . "-01-01")), $to_date);
                            $saturday_sunday = countSundaysAndEvenSaturdays(date('Y-m-d', strtotime($current_year . "-01-01")), $to_date);
                            $sick_leave_count = $sick_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                        }
                    }
                }
            }

            //Calculate Casual Leave Count
            $casual_leave_count = 0;
            if (!$casual_leaves->isEmpty()) {
                foreach ($casual_leaves as $casual_leave) {
                    //var_dump($casual_leave);
                    $from_year = date('Y', $casual_leave->from_date);
                    $from_date = date('Y-m-d', $casual_leave->from_date);
                    $to_year = date('Y', $casual_leave->to_date);
                    $to_date = date('Y-m-d', $casual_leave->to_date);
                    $current_year = date('Y');
                    if ($from_year == $current_year || $to_year == $current_year) {
                        //echo $casual_leave->to_date . "===" . $casual_leave->from_date;
                        if ($from_year == $current_year && $to_year == $current_year) {
                            $datediff = $casual_leave->to_date - $casual_leave->from_date;
                            if (date("Y-m-d", $casual_leave->from_date) == date("Y-m-d", $casual_leave->to_date)) {
                                $casual_leave_count += 1;
                            } else {
                                $casual_leave_count += (round($datediff / (60 * 60 * 24))) + 1;
                                $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date, $to_date);
                                $saturday_sunday = countSundaysAndEvenSaturdays($from_date, $to_date);
                                $casual_leave_count = $casual_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                            }
                        } else if ($from_year == $current_year && $to_year == $current_year + 1) {
                            $your_date = strtotime($from_date);
                            $datediff = strtotime($current_year . "-12-31") - $your_date;
                            $casual_leave_count += (round($datediff / (60 * 60 * 24))) + 1;
                            $no_of_holidays = numberOfHolidayExisted($holidays_list, $from_date, date(strtotime($current_year . "-12-31")));
                            $saturday_sunday = countSundaysAndEvenSaturdays($from_date, date('Y-m-d', strtotime($current_year . "-12-31")));
                            $casual_leave_count = $casual_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                        } else if ($from_year == $current_year - 1 && $to_year == $current_year) {
                            $your_date = strtotime($to_date);
                            $datediff = $your_date - strtotime($current_year . "-01-01");
                            $casual_leave_count += (round($datediff / (60 * 60 * 24))) + 1;
                            $no_of_holidays = numberOfHolidayExisted($holidays_list, date(strtotime($current_year . "-01-01")), $to_date);
                            $saturday_sunday = countSundaysAndEvenSaturdays(date('Y-m-d', strtotime($current_year . "-01-01")), $to_date);
                            $casual_leave_count = $casual_leave_count - $no_of_holidays - $saturday_sunday['sundays'] - $saturday_sunday['evenSaturdays'];
                        }
                    }
                }
            }
            $export_data[$key]["emp_id"] = $user->emp_id;
            $export_data[$key]["name"] = $user->name;
            $available_cfl_count = $carry_forwarded_leave_count >= $casual_leave_count ? $carry_forwarded_leave_count - $casual_leave_count : 0;
            $export_data[$key]["carry_forward"] = $carry_forwarded_leave_count >= $casual_leave_count ? $carry_forwarded_leave_count - $casual_leave_count : 0;
            $available_sick_leave_count = $leaves_count->sick = (($leaves_count->sick/12)*date("m", strtotime($this->to_date)));
            $export_data[$key]["sick"] = $leaves_count->sick - $sick_leave_count;
            $leaves_count->casual = (($leaves_count->casual/12)*date("m", strtotime($this->to_date)));
            $available_casual_leave_count = $carry_forwarded_leave_count < $casual_leave_count ? $leaves_count->casual + $carry_forwarded_leave_count - $casual_leave_count : $leaves_count->casual;
            $export_data[$key]["casual"] = $carry_forwarded_leave_count < $casual_leave_count ? $leaves_count->casual + $carry_forwarded_leave_count - $casual_leave_count : $leaves_count->casual;
        }

        return collect($export_data);
    }

    public function headings(): array
    {
        return [
            'EMP ID',
            'Name',
            'Carry Forward',
            'Sick',
            'Casual'
        ];
    }
}
