<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, StaffController, ModalController, AssessmentController};

//Staff's routes
Route::name('staff.')->prefix('staff')->middleware(['staff', 'auth', 'verified'])->group(function () {

    Route::get('dashboard', [StaffController::class, 'dashboard'])->name('dashboard');

    //Timesheet
    Route::get('timesheet', [StaffController::class, 'timesheet'])->name('timesheet');
    Route::post('timesheet/add-working-log', [StaffController::class, 'add_working_log'])->name('timesheet.add_working_log');


    //Attendance
    Route::get('attendance', [StaffController::class, 'attendance'])->name('attendance');
    Route::post('attendance/add', [StaffController::class, 'attendance_add'])->name('attendance.add');


    //Leave application
    Route::post('leave-application/add', [StaffController::class, 'leave_application_add'])->name('leave_application.add');

    //Assessments
    Route::get('assessment', [StaffController::class, 'assessment'])->name('assessment');

});