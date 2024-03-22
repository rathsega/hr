<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\{LeaveApplicationController, TimesheetController, AssessmentController, AttendanceController, TasksController, PayslipController, PerformanceController, InventoryItemController, MyProfileController, HolidaysController, BirthdaysController, OrganisationController, SeparationController, FeedbackController, AnnouncementsController};

//Staff's routes
Route::name('staff.')->prefix('staff')->middleware(['staff', 'auth', 'verified'])->group(function () {

    Route::get('dashboard', function(){return view('staff.dashboard.index');})->name('dashboard');

    //Timesheet
    Route::get('timesheet',[TimesheetController::class, 'index'])->name('timesheet');
    Route::post('timesheet/store', [TimesheetController::class, 'store'])->name('timesheet.store');
    Route::post('timesheet/update/{id}', [TimesheetController::class, 'update'])->name('timesheet.update');
    Route::get('timesheet/delete/{id}', [TimesheetController::class, 'delete'])->name('timesheet.delete');

    //Task manager
    Route::get('tasks/{tasks_type}',[TasksController::class, 'index'])->name('tasks');
    Route::post('task/store/{user_id?}',[TasksController::class, 'store'])->name('task.store');
    Route::post('task/update/{id}',[TasksController::class, 'update'])->name('task.update');
    Route::get('task/completion',[TasksController::class, 'task_completion'])->name('task.completion');
    Route::get('task/status',[TasksController::class, 'task_status'])->name('task.status');
    Route::get('task/delete/{id}',[TasksController::class, 'task_delete'])->name('task.delete');
    Route::post('task/sort',[TasksController::class, 'sort'])->name('task.sort');

    //Attendance
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('attendance/update/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('attendance/delete/{id}', [AttendanceController::class, 'delete'])->name('attendance.delete');

    //Leave application
    Route::get('leave-report', [LeaveApplicationController::class, 'index'])->name('leave.report');
    Route::post('leave-report/store', [LeaveApplicationController::class, 'store'])->name('leave.report.store');
    Route::get('leave-report/delete/{id}', [LeaveApplicationController::class, 'delete'])->name('leave.report.delete');

    //Performances
    Route::get('performance', [PerformanceController::class, 'index'])->name('performance');

    //Assessments
    Route::get('assessment', [AssessmentController::class, 'index'])->name('assessment');

    //Payslip
    Route::get('payslip', [PayslipController::class, 'index'])->name('payslip');
    Route::get('payslip/download', [PayslipController::class, 'payslip_download'])->name('payslip.download');
    Route::get('payslip/download_new_payslip', [PayslipController::class, 'download_new_payslip'])->name('payslip.download_new_payslip');

    //Inventory
    Route::get('inventory/item', [InventoryItemController::class, 'index'])->name('inventory.item');

    //My profile
    Route::get('my-profile/{tab?}/{user_id?}', [MyProfileController::class, 'index'])->name('my.profile');
    Route::post('my-profile/update/{user_id?}', [MyProfileController::class, 'update'])->name('my.profile.update');

    //Change Password
    Route::get('password/change', [MyProfileController::class, 'change_password'])->name('change.password');
    Route::post('password/update', [MyProfileController::class, 'password_update'])->name('password.update');

    //Holidays
    Route::get('holidays', [HolidaysController::class, 'index'])->name('holidays');

    //Holidays
    Route::get('birthdays', [BirthdaysController::class, 'index'])->name('birthdays');

    //Organization
    Route::get('organisation', [OrganisationController::class, 'index'])->name('organisation');

    //Separation
    Route::get('separation', [SeparationController::class, 'index'])->name('separation');
    Route::post('separation/store', [SeparationController::class, 'store'])->name('separation.store');
    Route::get('separation/revoke/{id?}', [SeparationController::class, 'revoke'])->name('separation.revoke');
    Route::get('separation/view/{id?}', [SeparationController::class, 'view'])->name('separation.view');
    Route::post('separation/manager_approvals}', [SeparationController::class, 'manager_approvals'])->name('separation.manager_approvals');
    Route::post('separation/it_manager_approvals}', [SeparationController::class, 'it_manager_approvals'])->name('separation.it_manager_approvals');
    Route::post('separation/finance_manager_approvals}', [SeparationController::class, 'finance_manager_approvals'])->name('separation.finance_manager_approvals');
    Route::post('separation/hr_manager_approvals}', [SeparationController::class, 'hr_manager_approvals'])->name('separation.hr_manager_approvals');

    //Feedback
    Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback');
    Route::post('feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');

    //Announcements
    Route::get('announcements', [AnnouncementsController::class, 'index'])->name('announcements');
});
