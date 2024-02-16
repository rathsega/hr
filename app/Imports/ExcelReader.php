<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use App\Models\UploadUsersModel;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;

class ExcelReader implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if($row['email'] == $row['manager']){
            $manager_id = NULL;
        }else{
            $manager_id = User::select('id')->where('email',$row['manager'])->first();
        }


        $department_id = Department::select('id')->where('title',$row['department'])->first();
        // var_dump($row['dob']);exit;
        // Define how the data should be mapped to your model
        
        return new UploadUsersModel([
            'name' => $row['name'] ? $row['name'] : 'test',
            'email' => $row['email'] ? $row['email'] : 'test@zettamine.com',
            'role' => $row['role'],
            'manager' => $manager_id ? $manager_id->id : 0,
            'department' => $department_id ? $department_id->id : 0,
            'billingtype' => $row['billing'] == 'Non - Billable' ? 'non-billable' : 'billable',
            'employmenttype' => $row['employment'] == 'Fulltime' ? 'full time' : 'contract',
            'birthday' => gmdate('Y-m-d', ($row['dob'] - 25569) * 86400),
            'designation' => $row['designation'],
            'pan_number' => $row['pan_number'],
            'aadhar_number' => $row['aadhar_number'],
            'uan_number' => $row['uan_number'],
            'pf_number' => $row['pf_number'],
            'passport_number' => $row['passport_number'],
            'passport_expiry_date' => gmdate('Y-m-d', ($row['passport_expiry_date'] - 25569) * 86400),
            'bank_name' => $row['bank_name'],
            'bank_account_number' => $row['bank_account_number'],
            'ifsc_code' => $row['ifsc_code'], 
            'emp_id' => $row['emp_id'], 
            'password'=>Hash::make('Workplace@123'),
            'carry_forwarded_leaves_count'=>$row['carry_forwarded_leaves_count'],
            'salary_package'=>$row['salary_package'],
            'joining_date'=>gmdate('Y-m-d', ($row['joining_date'] - 25569) * 86400),
            'role'=> 'staff',
            'status'=> 'active',
            // Add more columns as needed
        ]);
    }
}
