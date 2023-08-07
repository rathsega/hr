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
		return redirect(route('dashboard'));
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




require __DIR__.'/auth.php';
