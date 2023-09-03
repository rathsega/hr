<?php

namespace App\Http\Controllers;

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

        if (auth()->user()->role == 'admin') {
            $page_data['users'] = User::where('status', 'active')->orderBy('sort')->get();
        } else {
            $page_data['users'] = User::where('id', auth()->user()->id)->get();
        }

        return view(auth()->user()->role . '.payslip.index', $page_data);
    }

    function store(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            $data['user_id'] = $request->user_id;
        } elseif (auth()->user()->role == 'staff') {
            $data['user_id'] = auth()->user()->id;
        }

        $this->validate($request, [
            'user_id' => 'required',
            'month_of_salary' => 'required',
            'net_salary' => 'required',
            'bonus' => 'required',
            'penalty' => 'required'
        ]);


        $data['user_id'] = $request->user_id;
        $data['net_salary'] = $request->net_salary;
        $data['bonus'] = $request->bonus;
        $data['penalty'] = $request->penalty;
        $data['status'] = 1;
        $data['month_of_salary'] = $request->month_of_salary;
        $data['note'] = $request->note;

        $invoice_id = Payslip::insertGetId($data);

        return redirect(route('admin.payslip'))->with('success_message', __('Invoice created successfully'));
    }

    function delete(Request $request)
    {
        removeFile(Payslip::where('id', $request->id)->value('invoice'));
        Payslip::where('id', $request->id)->delete();
        return redirect(route('admin.payslip'))->with('success_message', get_phrase('Invoice deleted successfully'));
    }

    function payslip_download(Request $request)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html_content = view('admin.payslip.invoice_with_assessment', ['invoice_id' => $request->invoice_id, 'user_id' => $request->user_id])->render();
        $dompdf->loadHtml($html_content);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $payslip = Payslip::where('id', $request->invoice_id)->first();
        $dompdf->stream('Payslip-' . date('F-Y', strtotime($payslip->month_of_salary)) . '.pdf');
    }

    function payslip_send_to_email(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $payslip = Payslip::where('id', $request->invoice_id)->first();
        $page_data['invoice_id'] = $request->invoice_id;
        $page_data['user_id'] = $request->user_id;

        $dompdf = new Dompdf();
        $html_content = view('admin.payslip.invoice', ['invoice_id' => $request->invoice_id, 'user_id' => $request->user_id])->render();
        $dompdf->loadHtml($html_content); // Load the HTML content
        $dompdf->render(); // Render the PDF

        config(['mail.from.name' => 'Creativeitem Workplace']);
        config(['mail.from.address' => 'admin@example.com']);
        // Mail::send('admin.payslip.invoice_with_assessment', $page_data, function ($message) use ($payslip, $user, $dompdf) {
        //     $message->to($user->email, $user->name)
        //         ->subject('Monthly Salary of ' . date('1 M - t M, Y', strtotime($payslip->month_of_salary)) . ' - Creativeitem')
        //         ->attachData($dompdf->output(), 'Payslip-' . date('F-Y', strtotime($payslip->month_of_salary)) . '.pdf');
        // });

        try {
            Mail::send('admin.payslip.invoice_with_assessment', $page_data, function ($message) use ($payslip, $user, $dompdf) {
                $message->to($user->email, $user->name)
                    ->subject('Monthly Salary of ' . date('1 M - t M, Y', strtotime($payslip->month_of_salary)) . ' - Creativeitem')
                    ->attachData($dompdf->output(), 'Payslip-' . date('F-Y', strtotime($payslip->month_of_salary)) . '.pdf');
            });
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

	    
        Payslip::where('id', $payslip->id)->update(['email_sent' => 1]);

        return redirect(route('admin.payslip'))->with('success_message', get_phrase('Invoice sent successfully'));
    }
}
