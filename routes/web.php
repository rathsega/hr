<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, StaffController, ModalController};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Cache clearing route
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Application cache cleared';
});

//Root route
Route::get('/', function () {

	if(auth()->user()->role == 'admin'){
		return redirect(route('admin.dashboard'));
	}elseif(auth()->user()->role == 'staff'){
		return redirect(route('staff.dashboard'));
	}
    return view('auth/login');
})->middleware(['auth', 'verified'])->name('root');

//Logout route
Route::get('/logout', function () {
	Auth::logout();
	return redirect(route('login'));
})->name('logout');

//Modal controllers group routing
Route::controller(ModalController::class)->group(function () {
    Route::any('/right-modal/{view_path}', 'right_modal')->name('right_modal');
});

//Admin's routes
Route::controller(AdminController::class)->middleware(['admin', 'auth', 'verified'])->group(function () {

    Route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');

    //Timesheet
    Route::get('/admin/timesheet', 'timesheet')->name('admin.timesheet');
    Route::post('/admin/timesheet/add-working-log', 'add_working_log')->name('admin.timesheet.add_working_log');

    //Task manager
    Route::get('/admin/task-manager', 'task_manager')->name('admin.task_manager');
    Route::post('/admin/task-manager/update/{user_id}', 'task_manager_update')->name('admin.task_manager.update');

    //Attendance
    Route::get('/admin/attendance', 'attendance')->name('admin.attendance');
    Route::post('/admin/attendance/add', 'attendance_add')->name('admin.attendance.add');

    //Leave application
    Route::post('/admin/leave-application/add', 'leave_application_add')->name('admin.leave_application.add');

    //Staffs
    Route::get('/admin/staff', 'staff')->name('admin.staff');
    Route::post('/admin/staff/add', 'staff_add')->name('admin.staff.add');
    Route::post('/admin/staff/update/{user_id}', 'staff_update')->name('admin.staff.update');
    Route::get('/admin/staff/delete/{user_id}', 'staff_delete')->name('admin.staff.delete');
    Route::get('/admin/staff/status/{status}/{user_id}', 'staff_status')->name('admin.staff.status');
    Route::post('/admin/staff-sort/update', 'staff_sort')->name('admin.staff_sort.update');

    //Assessments
    Route::get('/admin/assessment', 'assessment')->name('admin.assessment');
    Route::post('/admin/assessment/add', 'assessment_add')->name('admin.assessment.add');
    Route::post('/admin/rating/update', 'assessment_rating_update')->name('admin.rating.update');

});


//Staff's routes
Route::controller(StaffController::class)->middleware(['staff', 'auth', 'verified'])->group(function () {

    Route::get('/staff/dashboard', 'dashboard')->name('staff.dashboard');

    //Timesheet
    Route::get('/staff/timesheet', 'timesheet')->name('staff.timesheet');
    Route::post('/staff/timesheet/add-working-log', 'add_working_log')->name('staff.timesheet.add_working_log');


    //Attendance
    Route::get('/staff/attendance', 'attendance')->name('staff.attendance');
    Route::post('/staff/attendance/add', 'attendance_add')->name('staff.attendance.add');


    //Leave application
    Route::post('/staff/leave-application/add', 'leave_application_add')->name('staff.leave_application.add');

    //Assessments
    Route::get('/staff/assessment', 'assessment')->name('staff.assessment');

});




require __DIR__.'/auth.php';
