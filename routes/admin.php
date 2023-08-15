<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, TimesheetController, StaffController, ModalController, AssessmentController, AttendanceController, TasksController};

//Admin's routes
Route::name('admin.')->prefix('admin')->middleware(['admin', 'auth', 'verified'])->group(function () {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //Timesheet
    Route::get('timesheet',[TimesheetController::class, 'index'])->name('timesheet');
    Route::post('timesheet/store', [TimesheetController::class, 'store'])->name('timesheet.store');

    //Task manager
    Route::get('tasks/{tasks_type}',[TasksController::class, 'index'])->name('tasks');
    Route::post('task/store/{user_id?}',[TasksController::class, 'store'])->name('task.store');
    Route::post('task/update/{id}',[TasksController::class, 'update'])->name('task.update');
    Route::get('task/completion',[TasksController::class, 'task_completion'])->name('task.completion');
    Route::get('task/status',[TasksController::class, 'task_status'])->name('task.status');
    //Route::post('task-manager/update/{user_id}', [AdminController::class, 'task_manager_update'])->name('task_manager.update');

    //Attendance
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    //Leave application
    Route::get('leave', [LeaveApplicationController::class, 'index'])->name('leave');


    //Staffs
    Route::get('staff', [AdminController::class, 'staff'])->name('staff');
    Route::post('staff/add', [AdminController::class, 'staff_add'])->name('staff.add');
    Route::post('staff/update/{user_id}', [AdminController::class, 'staff_update'])->name('staff.update');
    Route::get('staff/delete/{user_id}', [AdminController::class, 'staff_delete'])->name('staff.delete');
    Route::get('staff/status/{status}/{user_id}', [AdminController::class, 'staff_status'])->name('staff.status');
    Route::post('staff-sort/update', [AdminController::class, 'staff_sort'])->name('staff_sort.update');

    //Assessments
    Route::get('assessment', [AssessmentController::class, 'index'])->name('assessment');
    Route::post('assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');
    Route::get('assessment/team-report/{id?}', [AssessmentController::class, 'team_report'])->name('assessment.team.report');
    Route::post('assessment/rating/update/{id}', [AssessmentController::class, 'assessment_rating_update'])->name('assessment.rating.update');
    Route::get('assessment/daily-report', [AssessmentController::class, 'daily_report'])->name('assessment.daily.report');
    Route::post('assessment/incident/store', [AssessmentController::class, 'incident_store'])->name('assessment.incident.store');
    

});

