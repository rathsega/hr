<?php
namespace App\Exports;

use App\Models\{User, Payslip};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class JoiningsExport implements FromCollection, WithHeadings
{

    var $from_date;
    var $to_date;
    public function __construct($from_date, $to_date) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }
    public function collection()
    {
        $data = DB::select("SELECT u.name AS Name, u.emp_id, u.designation, u.phone, u.employmenttype, u.billingtype, u.salary_package, u.joining_date from users as u where u.joining_date BETWEEN '".$this->from_date."' AND '".$this->to_date."' ");
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
            'Monthly Salary',
            'Joining Date',
            // Add more headings as needed
        ];
    }
}
