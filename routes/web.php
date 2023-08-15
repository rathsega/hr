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
use Illuminate\Routing\Router;
//Cache clearing route
Route::get('/clear-cache', function (Router $route) {
    $r = $route->getRoutes();
    foreach ($r as $value) {
        echo $value->uri();
        echo "<br/>";
    }

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


Route::get('/location-validity-check', function (Request $request) {
	$session_data = session();
    if(
        is_array($session_data) && 
        array_key_exists('table', $session_data) && $session_data['table'] != '' &&
        array_key_exists('location', $session_data) && $session_data['location'] != '' &&
        array_key_exists('id', $session_data) && $session_data['id'] != ''
    ){
        \DB::table($session_data['table'])->where('id', $session_data['id'])->update(['location' => getCurrentLocation($request->lat, $request->lon)]);
        session(['table' => '', 'location' => '', 'id' => '']);
    }
})->name('location.validity.check');



require __DIR__.'/auth.php';
