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
        $manager_id = User::select('id')->where('email',$row['manager'])->first();
        $department_id = Department::select('id')->where('title',$row['department'])->first();
        // var_dump($row['dob']);exit;
        // Define how the data should be mapped to your model
        return new UploadUsersModel([
            'name' => $row['name'],
            'email' => $row['email'],
            'role' => $row['role'],
            'manager' => $manager_id->id,
            'department' => $department_id->id,
            'billingtype' => $row['billing'],
            'employmenttype' => $row['employment'],
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
            'password'=>Hash::make('Workplace@123')
            // Add more columns as needed
        ]);
    }
}
