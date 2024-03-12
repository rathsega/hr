<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance, Payslip};
use Session, Image;
use Dompdf\Dompdf;
use Mail;

class PayslipController extends Controller
{

    function index()
    {
        $page_data['users'] = User::where('id', auth()->user()->id)->get();
        return view(auth()->user()->role . '.payslip.index', $page_data);
    }

    function payslip_download(Request $request)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html_content = view('staff.payslip.invoice_with_assessment', ['invoice_id' => $request->invoice_id, 'user_id' => $request->user_id])->render();
        $dompdf->loadHtml($html_content);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $payslip = Payslip::where('id', $request->invoice_id)->first();
        $dompdf->stream('Payslip-' . date('F-Y', strtotime($payslip->month_of_salary)) . '.pdf');
    }

    function download_new_payslip(Request $request)
    {
        $data = [];
        $data['payslip'] = DB::select("select *, p.id as payslip_id from payslips as p INNER join users as u on u.id = p.user_id inner join departments as d on d.id = u.department  where p.user_id = ".auth()->user()->id ." and  p.id=".$request->id);
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        if($data['payslip'][0]->employmenttype == 'full time'){
            $html_content = view(auth()->user()->role . '.payslip.generateinvoicefulltime', $data)->render();
        }else if($data['payslip'][0]->employmenttype == 'contract'){
            $html_content = view(auth()->user()->role . '.payslip.generateinvoicecontract', $data)->render();
        }
        $dompdf->loadHtml($html_content);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream('Payslip-' . date('F-Y', strtotime($data['payslip'][0]->month_of_salary)) . '.pdf');
    }

}
