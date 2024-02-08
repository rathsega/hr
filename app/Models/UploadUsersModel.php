<?php
// app/YourModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UploadUsersModel extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'manager',
        'department',
        'billingtype',
        'employmenttype',
        'designation',
        'birthday',
        'pan_number',
        'aadhar_number',
        'uan_number',
        'pf_number',
        'passport_number',
        'passport_expiry_date',
        'bank_name',
        'bank_account_number',
        'ifsc_code',
        'role',
        'emp_id'
        // Add more columns as needed
    ];

    // You can add additional methods or relationships here if needed
}
