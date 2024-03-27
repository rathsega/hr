<?php
namespace App\Exports;

use App\Models\{User, Payslip};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class PayslipsExport implements FromCollection, WithHeadings
{

    var $month;
    var $year;
    public function __construct($selected_month, $selected_year) {
        $this->month = $selected_month;
        $this->year = $selected_year;
    }
    public function collection()
    {
        $month_of_salary = "". $this->year . "-" . $this->month . "-1 00:00:00";
        $data = DB::select("SELECT u.emp_id, u.bank_account_number, u.ifsc_code, u.designation, d.title, u.pf_number, u.joining_date, p.month_of_salary, u.name, u.uan_number, p.esi_number, p.esi_flag, p.pre_ctc, u.salary_package, p.net_salary, p.total_working_days, p.loss_of_pay, p.workingdays, p.basic, p.hra, p.conveyance, p.medical, p.lta, p.education_allowance, p.hostel_allowance,p.motor_vehicle_perq, p.motor_vehicle_all,p.professional_dev_expenses,p.meal_allowances, p.special_allowance, p.gross_salary, p.statutory_bonus, p.ot_other, p.total_earnings, p.salary_advance, p.pf, p.employee_esi, p.pt, p.it_deduction, p.medical_deduction, p.other_deduction, p.meal_allowances, p.deductions, p.net_salary, p.net_salary, p.emlpoyer_pf, p.gratuity, p.employer_esi, u.salary_package, p.variable_salary, u.salary_package    FROM `payslips` as p inner join users as u on u.id = p.user_id inner join departments as d on d.id = u.department where p.month_of_salary = '". $month_of_salary . "'");
        return collect($data);
        //return  Payslip::whereDate('month_of_salary', $this->year . '-' . $this->month . '-1 00:00:00')->get();
    }

    public function headings(): array
    {
        return [
            'EMP ID',
            'Account Number',
            'IFSC Code',
            'Designation',
            'Department',
            'PF Account Number',
            'DOJ',
            'Payroll Month',
            'Employee Name',
            'UAN',
            'ESI Number',
            'ESI Flag',
            'Pre CTC',
            'CTC',
            'Earned Salary',
            'Total Working Days',
            'LOP',
            'Actual Working Days',
            'Basic',
            'HRA',
            'Conveyance',
            'Medical',
            'LTA',
            'Education Allowance',
            'Hostel Allowance',
            'Motor Vehicle  Perq',
            'Motor Vehicle All',
            'Professional Devp., Expenses',
            'Meal  Allowances',
            'Special Allowance',
            'Gross',
            'Statutory Bonus',
            'OT /Others',
            'Total Earnings',
            'Sal Adv',
            'PF',
            'ESI',
            'PT',
            'IT Deduction',
            'Medical Deduction',
            'Other Deduction',
            'Meal  Allowances',
            'Total Deduction',
            'NET',
            'Net Rounded',
            'Employer PF',
            'Gratuity',
            'Employer ESI',
            'Fixed CTC',
            'Variable Sal',
            'Total CTC'
            
            // Add more headings as needed
        ];
    }
}
