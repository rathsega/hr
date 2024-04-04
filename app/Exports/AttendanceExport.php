<?php
namespace App\Exports;

use App\Models\{User, Payslip};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AttendanceExport implements FromCollection, WithHeadings
{

    var $from_date;
    var $to_date;
    public function __construct($from_date, $to_date) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }
    public function collection()
    {
        $data = DB::select("SELECT u.name AS Name, IFNULL(FROM_UNIXTIME(a.checkin), 'No Checkin') AS Checkin_Time, IFNULL(FROM_UNIXTIME(a.checkout), 'No Checkout') AS Checkout_Time, d.date AS Date FROM users u CROSS JOIN ( SELECT DISTINCT DATE(FROM_UNIXTIME(checkin)) AS date FROM attendances WHERE DATE(FROM_UNIXTIME(checkin)) BETWEEN '".$this->from_date."' AND '".$this->to_date."' ) AS d LEFT JOIN attendances a ON u.id = a.user_id AND DATE(FROM_UNIXTIME(a.checkin)) = d.date ORDER BY u.name, d.date");
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Checkin Time',
            'Checkout Time',
            'Date'
            // Add more headings as needed
        ];
    }
}
