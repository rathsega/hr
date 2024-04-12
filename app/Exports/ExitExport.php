<?php
namespace App\Exports;

use App\Models\{User, Payslip};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExitExport implements FromCollection, WithHeadings
{

    var $from_date;
    var $to_date;
    public function __construct($from_date, $to_date) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }
    public function collection()
    {
        $data = DB::select("SELECT u.name AS Name, u.emp_id, u.designation, u.phone, u.employmenttype, u.billingtype, u.joining_date, s.user_proposed_last_working_day, s.hr_proposed_last_working_day, s.actual_last_working_day from users as u right join separation as s on s.user_id = u.id where s.status = 'Relieved' and COALESCE(s.hr_proposed_last_working_day, s.user_proposed_last_working_day, s.actual_last_working_day) BETWEEN '".$this->from_date."' AND '".$this->to_date."' ");
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Name',
            'EMP ID',
            'Designation',
            'Phone',
            'Employment Type',
            'Billing Type',
            'Joining Date',
            'User Proposed Last Working Day',
            'HR Proposed Last Working Day',
            'Actual Last Working Day'
            // Add more headings as needed
        ];
    }
}
