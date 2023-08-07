<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, StaffController, ModalController, AssessmentController};

//Admin's routes
Route::name('admin.')->prefix('admin')->middleware(['admin', 'auth', 'verified'])->group(function () {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //Timesheet
    Route::get('timesheet',[AdminController::class, 'timesheet'])->name('timesheet');
    Route::post('timesheet/add-working-log', [AdminController::class, 'add_working_log'])->name('timesheet.add_working_log');

    //Task manager
    Route::get('task-manager',[AdminController::class, 'task_manager'])->name('task_manager');
    Route::post('task-manager/update/{user_id}', [AdminController::class, 'task_manager_update'])->name('task_manager.update');

    //Attendance
    Route::get('attendance', [AdminController::class, 'attendance'])->name('attendance');
    Route::post('attendance/add', [AdminController::class, 'attendance_add'])->name('attendance.add');

    //Leave application
    Route::post('leave-application/add', [AdminController::class, 'leave_application_add'])->name('leave_application.add');

    //Staffs
    Route::get('staff', [AdminController::class, 'staff'])->name('staff');
    Route::post('staff/add', [AdminController::class, 'staff_add'])->name('staff.add');
    Route::post('staff/update/{user_id}', [AdminController::class, 'staff_update'])->name('staff.update');
    Route::get('staff/delete/{user_id}', [AdminController::class, 'staff_delete'])->name('staff.delete');
    Route::get('staff/status/{status}/{user_id}', [AdminController::class, 'staff_status'])->name('staff.status');
    Route::post('staff-sort/update', [AdminController::class, 'staff_sort'])->name('staff_sort.update');

    //Assessments
    Route::get('assessment', [AdminController::class, 'assessment'])->name('assessment');
    Route::post('assessment/add', [AdminController::class, 'assessment_add'])->name('assessment.add');
    Route::post('rating/update', [AdminController::class, 'assessment_rating_update'])->name('rating.update');

    Route::get('assessment/team-report/{id?}', [AssessmentController::class, 'team_report'])->name('assessment.team.report');
    Route::post('assessment/rating/update/{id}', [AssessmentController::class, 'assessment_rating_update'])->name('assessment.rating.update');
    
    Route::get('assessment/daily-report', [AssessmentController::class, 'daily_report'])->name('assessment.daily.report');
    Route::post('assessment/incident/store', [AssessmentController::class, 'incident_store'])->name('assessment.incident.store');
    

});

