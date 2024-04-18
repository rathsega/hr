<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{LeaveApplicationController, TimesheetController, StaffController, AssessmentController, AttendanceController, TasksController, PayslipController, SettingsController, PerformanceController, PerformanceCriteriaController, InventoryController, InventoryItemController, BranchController, MyProfileController, DepartmentController, HolidaysController, BirthdaysController, OrganisationController, UploadUsersController, PayrollConfigurationController, SeparationController, FeedbackController, AnnouncementsController, EmployeeOfTheMonthController, EmployersQuote, ReportsController, ClientsController, BillableTimesheetsController, ReminderController};

Route::name('admin.')->prefix('admin')->group(function () {
    //Timesheet Remider
    Route::get('timesheetreminder',[ReminderController::class, 'index'])->name('timesheetreminder');
});
//Admin's routes
Route::name('admin.')->prefix('admin')->middleware(['admin', 'auth', 'verified'])->group(function () {

    Route::get('dashboard', function(){return view('admin.dashboard.index');})->name('dashboard');

    //Timesheet
    Route::get('timesheet',[TimesheetController::class, 'index'])->name('timesheet');
    Route::post('timesheet/store', [TimesheetController::class, 'store'])->name('timesheet.store');
    Route::post('timesheet/update/{id}', [TimesheetController::class, 'update'])->name('timesheet.update');
    Route::get('timesheet/delete/{id}', [TimesheetController::class, 'delete'])->name('timesheet.delete');
    Route::post('timesheet/status/{id}', [TimesheetController::class, 'change_status'])->name('timesheet.report.status');

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
    Route::post('attendance/status/{id}', [AttendanceController::class, 'change_status'])->name('attendance.report.status');
    Route::post('attendance/reports', [AttendanceController::class, 'reports'])->name('attendance.reports');
    Route::post('attendance/lateloginreports', [AttendanceController::class, 'lateloginreports'])->name('attendance.lateloginreports');

    //Leave application
    Route::get('leave-report', [LeaveApplicationController::class, 'index'])->name('leave.report');
    Route::post('leave-report/store', [LeaveApplicationController::class, 'store'])->name('leave.report.store');
    Route::post('leave-report/status/{id}', [LeaveApplicationController::class, 'change_status'])->name('leave.report.status');
    Route::get('leave-report/delete/{id}', [LeaveApplicationController::class, 'delete'])->name('leave.report.delete');
    Route::post('leave-report/update_leave_count', [LeaveApplicationController::class, 'update_leave_count'])->name('leave.report.update_leaves_count');
    Route::get('leave-report/cancel/{id?}/{leave_type?}/{from_date}/{to_date}', [LeaveApplicationController::class, 'cancel'])->name('leave.report.cancel');
    Route::post('leave-report/leavebalance', [LeaveApplicationController::class, 'leavebalance'])->name('leave.report.leavebalance');

    //Staffs
    Route::get('staffs', [StaffController::class, 'index'])->name('staffs');
    Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::post('staff/update/{user_id}', [StaffController::class, 'update'])->name('staff.update');
    Route::get('staff/delete/{user_id}', [StaffController::class, 'delete'])->name('staff.delete');
    Route::get('staff/status/{status}/{user_id}', [StaffController::class, 'staff_status'])->name('staff.status');
    Route::post('staff-sort/update', [StaffController::class, 'staff_sort'])->name('staff.sort.update');

    Route::get('staff/profile/{tab?}/{user_id?}', [StaffController::class, 'profile'])->name('staff.profile');
    Route::post('staff/profile-update/{user_id?}', [StaffController::class, 'profile_update'])->name('staff.profile.update');

    Route::post('staff/joiningreports', [StaffController::class, 'joiningreports'])->name('staff.joiningreports');
    Route::post('staff/exitreports', [StaffController::class, 'exitreports'])->name('staff.exitreports');

    //Performances
    Route::get('performance', [PerformanceController::class, 'index'])->name('performance');
    Route::post('performance/store', [PerformanceController::class, 'store'])->name('performance.store');
    Route::post('performance/update/{id}', [PerformanceController::class, 'update'])->name('performance.update');
    Route::get('performance/delete', [PerformanceController::class, 'delete'])->name('performance.delete');

    //Assessments
    Route::get('assessment', [AssessmentController::class, 'index'])->name('assessment');
    Route::post('assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');
    Route::post('assessment/update/{id}', [AssessmentController::class, 'update'])->name('assessment.update');
    Route::get('assessment/delete/{id}', [AssessmentController::class, 'delete'])->name('assessment.delete');

    //Payslip
    Route::get('payslip', [PayslipController::class, 'index'])->name('payslip');
    Route::post('payslip/store', [PayslipController::class, 'store'])->name('payslip.store');
    Route::post('payslip/update/{id}', [PayslipController::class, 'update'])->name('payslip.update');
    Route::get('payslip/delete', [PayslipController::class, 'delete'])->name('payslip.delete');
    Route::get('payslip/deleteAttachment', [PayslipController::class, 'deleteAttachment'])->name('payslip.deleteAttachment');
    Route::get('payslip/download', [PayslipController::class, 'payslip_download'])->name('payslip.download');
    Route::get('payslip/send', [PayslipController::class, 'payslip_send_to_email'])->name('payslip.send');
    Route::get('payslip/viewPayslip', [PayslipController::class, 'view_payslip'])->name('payslip.viewPayslip');
    Route::get('payslip/download_new_payslip', [PayslipController::class, 'download_new_payslip'])->name('payslip.download_new_payslip');

    //Branch
    Route::get('branch', [BranchController::class, 'index'])->name('branch');
    Route::post('branch/store', [BranchController::class, 'store'])->name('branch.store');
    Route::post('branch/update/{id}', [BranchController::class, 'update'])->name('branch.update');
    Route::get('branch/delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');

    //Department
    Route::get('department', [DepartmentController::class, 'index'])->name('department');
    Route::post('department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::post('department/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::get('department/delete/{id}', [DepartmentController::class, 'delete'])->name('department.delete');

    //Holidays
    Route::get('holidays', [HolidaysController::class, 'index'])->name('holidays');
    Route::post('holidays/store', [HolidaysController::class, 'store'])->name('holidays.store');
    Route::post('holidays/update/{id}', [HolidaysController::class, 'update'])->name('holidays.update');
    Route::get('holidays/delete/{id}', [HolidaysController::class, 'delete'])->name('holidays.delete');

    //Holidays
    Route::get('birthdays', [BirthdaysController::class, 'index'])->name('birthdays');

    //Organization
    Route::get('organisation', [OrganisationController::class, 'index'])->name('organisation');

    //Inventory
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::post('inventory/update/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('inventory/delete/{id}', [InventoryController::class, 'delete'])->name('inventory.delete');

    //Inventory
    Route::get('inventory/item', [InventoryItemController::class, 'index'])->name('inventory.item');
    Route::post('inventory/item/store', [InventoryItemController::class, 'store'])->name('inventory.item.store');
    Route::post('inventory/item/update/{id}', [InventoryItemController::class, 'update'])->name('inventory.item.update');
    Route::get('inventory/item/delete/{id}', [InventoryItemController::class, 'delete'])->name('inventory.item.delete');

    //Performance Criteria
    Route::get('performance-criteria', [PerformanceCriteriaController::class, 'index'])->name('performance.criteria');
    Route::post('performance-criteria/store', [PerformanceCriteriaController::class, 'store'])->name('performance.criteria.store');
    Route::post('performance-criteria/update/{id}', [PerformanceCriteriaController::class, 'update'])->name('performance.criteria.update');
    Route::get('performance-criteria/delete/{id}', [PerformanceCriteriaController::class, 'delete'])->name('performance.criteria.delete');

    //Settings
    Route::get('system-settings', [SettingsController::class, 'system_settings'])->name('system.settings');
    Route::post('system-settings/update', [SettingsController::class, 'update'])->name('system.settings.update');

    Route::post('system/logo/update', [SettingsController::class, 'update_logo'])->name('system.logo.update');

    Route::get('smtp-settings', [SettingsController::class, 'smtp_settings'])->name('smtp.settings');
    Route::post('smtp-settings/update', [SettingsController::class, 'update'])->name('smtp.settings.update');
    Route::get('system/about', [SettingsController::class, 'about'])->name('system.about');

    //My profile
    Route::get('my-profile/{tab?}/{user_id?}', [MyProfileController::class, 'index'])->name('my.profile');
    Route::post('my-profile/update/{user_id?}', [MyProfileController::class, 'update'])->name('my.profile.update');

    //Change Password
    Route::get('password/change', [MyProfileController::class, 'change_password'])->name('change.password');
    Route::post('password/update', [MyProfileController::class, 'password_update'])->name('password.update');
    
    //Organization
    Route::get('uploadusers', [UploadUsersController::class, 'index'])->name('uploadusers');
    Route::post('uploadusers/store', [UploadUsersController::class, 'store'])->name('uploadusers.store');
    
    //Payroll Configuration
    Route::get('payrollconfiguration', [PayrollConfigurationController::class, 'index'])->name('payrollconfiguration');
    Route::post('payrollconfiguration/store', [PayrollConfigurationController::class, 'store'])->name('payrollconfiguration.store');
    Route::post('payrollconfiguration/generate', [PayrollConfigurationController::class, 'generate'])->name('payrollconfiguration.generate');
    Route::post('payrollconfiguration/configure_extra_modules', [PayrollConfigurationController::class, 'configure_extra_modules'])->name('payrollconfiguration.configure_extra_modules');
    Route::get('payrollconfiguration/allowances', [PayrollConfigurationController::class, 'allowances'])->name('payrollconfiguration.allowances');
    Route::post('payrollconfiguration/add_allowances', [PayrollConfigurationController::class, 'add_allowances'])->name('payrollconfiguration.add_allowances');
    Route::post('payrollconfiguration/update_allowances/{allowance_id}', [PayrollConfigurationController::class, 'update_allowances'])->name('payrollconfiguration.update_allowances');
    Route::get('payrollconfiguration/delete_allowance/{allowance_id}', [PayrollConfigurationController::class, 'delete_allowance'])->name('payrollconfiguration.delete_allowance');
    Route::get('payrollconfiguration/advances', [PayrollConfigurationController::class, 'advances'])->name('payrollconfiguration.advances');
    Route::post('payrollconfiguration/add_advances', [PayrollConfigurationController::class, 'add_advances'])->name('payrollconfiguration.add_advances');
    Route::post('payrollconfiguration/update_advances/{advance_id}', [PayrollConfigurationController::class, 'update_advances'])->name('payrollconfiguration.update_advances');
    Route::get('payrollconfiguration/delete_advance/{advance_id}', [PayrollConfigurationController::class, 'delete_advance'])->name('payrollconfiguration.delete_advance');
    Route::post('payrollconfiguration/download_report', [PayrollConfigurationController::class, 'download_report'])->name('payrollconfiguration.download_report');
    //Separation
    Route::get('separation', [SeparationController::class, 'index'])->name('separation');
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
    Route::post('announcements/store', [AnnouncementsController::class, 'store'])->name('announcements.store');
    Route::post('announcements/update/{user_id}', [AnnouncementsController::class, 'update'])->name('announcements.update');
    Route::get('announcements/delete/{user_id}', [AnnouncementsController::class, 'delete'])->name('announcements.delete');

    //Employee Of The Month
    Route::get('eotm', [EmployeeOfTheMonthController::class, 'index'])->name('eotm');
    Route::post('eotm/store', [EmployeeOfTheMonthController::class, 'store'])->name('eotm.store');
    Route::post('eotm/update/{eotm_id}', [EmployeeOfTheMonthController::class, 'update'])->name('eotm.update');
    Route::get('eotm/delete/{eotm_id}', [EmployeeOfTheMonthController::class, 'delete'])->name('eotm.delete');

    //Employers Quote
    Route::get('quotes', [EmployersQuote::class, 'index'])->name('quotes');
    Route::post('quotes/store', [EmployersQuote::class, 'store'])->name('quotes.store');
    Route::post('quotes/update/{quote_id}', [EmployersQuote::class, 'update'])->name('quotes.update');
    Route::get('quotes/delete/{quote_id}', [EmployersQuote::class, 'delete'])->name('quotes.delete');

    //Reports
    Route::get('reports/attendance', [ReportsController::class, 'attendance'])->name('reports.attendance');
    Route::get('reports/latelogin', [ReportsController::class, 'latelogin'])->name('reports.latelogin');
    Route::get('reports/joining', [ReportsController::class, 'joining'])->name('reports.joining');
    Route::get('reports/exit', [ReportsController::class, 'exit'])->name('reports.exit');
    Route::get('reports/leavebalance', [ReportsController::class, 'leavebalance'])->name('reports.leavebalance');
    Route::get('reports/payroll', [ReportsController::class, 'payroll'])->name('reports.payroll');

    //Clients
    Route::get('clients', [ClientsController::class, 'index'])->name('clients');
    Route::post('clients/store', [ClientsController::class, 'store'])->name('clients.store');
    Route::post('clients/update/{id}', [ClientsController::class, 'update'])->name('clients.update');
    Route::get('clients/delete/{id}', [ClientsController::class, 'delete'])->name('clients.delete');
    Route::get('clients/log/{id?}', [ClientsController::class, 'log'])->name('clients.log');
    
    //Billable Timesheets
    Route::get('billabletimesheet',[BillableTimesheetsController::class, 'index'])->name('billabletimesheet');

    
});
