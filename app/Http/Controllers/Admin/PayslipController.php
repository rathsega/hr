<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Task, Timesheet, Attendance, Leave_application, Assessment, Staff_performance, Payslip, FileUploader};
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

        if($request->attachment){
            $filename = FileUploader::upload($request->attachment, 'uploads/payslip-attachment');
            $data['attachment'] = last(explode('/', $filename));
        }


        $invoice_id = Payslip::insertGetId($data);

        return redirect()->back()->with('success_message', __('Invoice created successfully'));
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

        if($request->attachment){
            $filename = FileUploader::upload($request->attachment, 'uploads/payslip-attachment');
            $data['attachment'] = last(explode('/', $filename));
        }

        Payslip::where('id', $id)->update($data);

        return redirect()->back()->with('success_message', __('Invoice updated successfully'));
    }

    function delete(Request $request)
    {
        Payslip::where('id', $request->id)->delete();
        return redirect()->back()->with('success_message', get_phrase('Invoice deleted successfully'));
    }

    function deleteAttachment(Request $request)
    {
        Payslip::where('id', $request->id)->update(array('attachment'=>''));
        $attachment = $request->attachment;
        $url = '../public/uploads/payslip-attachment/'. $attachment;
        if (is_file($url) && file_exists($url)) {
            unlink($url);
        }
        return redirect()->back()->with('success_message', get_phrase('Payslip deleted successfully'));
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

        $data = [];
        $data['payslip'] = DB::select("select *, p.id as payslip_id from payslips as p INNER join users as u on u.id = p.user_id where p.id=".$request->invoice_id);
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html_content = view(auth()->user()->role . '.payslip.generateinvoicefulltime', $data)->render();
        $dompdf->loadHtml($html_content);
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream('Payslip-' . date('F-Y', strtotime($data['payslip'][0]->month_of_salary)) . '.pdf');

        $attachment = $payslip->attachment; 
        if( $attachment){
            $payslip_file_url = base_path().'/public' . '/uploads/payslip-attachment/'. $attachment;
            $file_extension = last(explode('.',$payslip_file_url));
            $fileData = chunk_split(base64_encode(file_get_contents($payslip_file_url)));
        }
        

        try {
            if($attachment){
                Mail::send('admin.payslip.invoice_with_assessment', $page_data, function ($message) use ($payslip, $user, $payslip_file_url, $file_extension, $fileData) {
                    $message->to($user->email, $user->name)
                        ->subject('Monthly Salary of ' . date('1 M - t M, Y', strtotime($payslip->month_of_salary)) . ' - Creativeitem')
                ->attach($payslip_file_url /*, 'Payslip-' . date('F-Y', strtotime($payslip->month_of_salary)) . '.' . $file_extension*/);
                });
            }else{
                Mail::send('admin.payslip.invoice_with_assessment', $page_data, function ($message) use ($payslip, $user) {
                    $message->to($user->email, $user->name)
                        ->subject('Monthly Salary of ' . date('1 M - t M, Y', strtotime($payslip->month_of_salary)) . ' - Creativeitem');
                });
            }
            
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

	    
        Payslip::where('id', $payslip->id)->update(['email_sent' => 1]);

        return redirect()->back()->with('success_message', get_phrase('Invoice sent successfully'));
    }

    function view_payslip(Request $request){
        $data = [];
        $data['payslip'] = DB::select("select *, p.id as payslip_id from payslips as p INNER join users as u on u.id = p.user_id where p.id=".$request->id);
        
        if($data['payslip'][0]->employmenttype == 'full time'){
            return view(auth()->user()->role . '.payslip.viewpayslipfulltime', $data);
        }else if($data['payslip'][0]->employmenttype == 'contract'){
            return view(auth()->user()->role . '.payslip.viewpayslipcontract', $data);
        }
    }

    function download_new_payslip(Request $request)
    {
        $data = [];
        $data['payslip'] = DB::select("select *, p.id as payslip_id from payslips as p INNER join users as u on u.id = p.user_id where p.id=".$request->id);
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
