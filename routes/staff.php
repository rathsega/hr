<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LeaveApplicationController, TimesheetController, StaffController, ModalController, AssessmentController, AttendanceController, TasksController};

//Admin's routes
Route::name('staff.')->prefix('staff')->middleware(['staff', 'auth', 'verified'])->group(function () {

    Route::get('dashboard', function(){return view('staff.dashboard.index');})->name('dashboard');

    //Timesheet
    Route::get('timesheet',[TimesheetController::class, 'index'])->name('timesheet');
    Route::post('timesheet/store', [TimesheetController::class, 'store'])->name('timesheet.store');

    //Task manager
    Route::get('tasks/{tasks_type}',[TasksController::class, 'index'])->name('tasks');
    Route::post('task/store/{user_id?}',[TasksController::class, 'store'])->name('task.store');
    Route::post('task/update/{id}',[TasksController::class, 'update'])->name('task.update');
    Route::get('task/completion',[TasksController::class, 'task_completion'])->name('task.completion');
    Route::get('task/status',[TasksController::class, 'task_status'])->name('task.status');

    //Attendance
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

    //Leave application
    Route::get('leave-report', [LeaveApplicationController::class, 'index'])->name('leave.report');
    Route::post('leave-report/store', [LeaveApplicationController::class, 'store'])->name('leave.report.store');
    Route::get('leave-report/delete/{id}', [LeaveApplicationController::class, 'delete'])->name('leave.report.delete');


    //Assessments
    Route::get('assessment', [AssessmentController::class, 'index'])->name('assessment');
    Route::post('assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');
    Route::get('assessment/team-report/{id?}', [AssessmentController::class, 'team_report'])->name('assessment.team.report');
    Route::post('assessment/rating/update/{id}', [AssessmentController::class, 'assessment_rating_update'])->name('assessment.rating.update');
    Route::get('assessment/daily-report', [AssessmentController::class, 'daily_report'])->name('assessment.daily.report');
    Route::post('assessment/incident/store', [AssessmentController::class, 'incident_store'])->name('assessment.incident.store');
    

});

