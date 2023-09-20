<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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
            'brief_of_monthly_salary' => 'required',
            'net_salary' => 'required',
            'bonus' => 'required',
            'penalty' => 'required',
            'status' => 'required|numeric|min:0|max:1'
        ]);

        $brief_of_monthly_salary = strtotime(explode(' - ', $request->brief_of_monthly_salary)[0]);


        $data['user_id'] = $request->user_id;
        $data['net_salary'] = $request->net_salary;
        $data['bonus'] = $request->bonus;
        $data['penalty'] = $request->penalty;
        $data['status'] = $request->status;
        $data['month_of_salary'] = date('Y-m-d 00:00:00', $brief_of_monthly_salary);
        $data['note'] = $request->note;

        $invoice_id = Payslip::insertGetId($data);

        return redirect(route('admin.payslip'))->with('success_message', __('Invoice created successfully'));
    }

    function update($id = "", Request $request)
    {

        $this->validate($request, [
            'brief_of_monthly_salary' => 'required',
            'net_salary' => 'required',
            'bonus' => 'required',
            'penalty' => 'required',
            'status' => 'required|numeric|min:0|max:1'
        ]);

        $brief_of_monthly_salary = strtotime(explode(' - ', $request->brief_of_monthly_salary)[0]);

        $data['net_salary'] = $request->net_salary;
        $data['bonus'] = $request->bonus;
        $data['penalty'] = $request->penalty;
        $data['status'] = $request->status;
        $data['month_of_salary'] = date('Y-m-d 00:00:00', $brief_of_monthly_salary);
        $data['note'] = $request->note;

        Payslip::where('id', $id)->update($data);

        return redirect(route('admin.payslip'))->with('success_message', __('Invoice updated successfully'));
    }

    function delete(Request $request)
    {
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
