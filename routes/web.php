<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HolidayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',[HomeController::class,'Login'])->name('login');
Route::post('/loginstore',[HomeController::class,'LoginStore'])->name('loginstore');
Route::get('/logout',[HomeController::class,'Logout'])->name('logout');
// Route::get('/forget-password', [DashboradController::class, 'showForgetPasswordForm'])->name('forget.password');
// Route::post('/forget-password', [DashboradController::class, 'sendResetLinkEmail'])->name('forget.password.email');
// Route::get('/reset/{token}', [DashboradController::class, 'reset'])->name('reset');
// Route::post('/reset/{token}', [DashboradController::class, 'postReset'])->name('post_reset');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::middleware(['auth'])->group(function () {

// Category

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/cpassword',[HomeController::class,'cPassword'])->name('changepass');
Route::post('/changepassword',[HomeController::class,'changePassword'])->name('changePassword');
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::get('/category/create', [CategoryController::class, 'createCategory'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('category.store');
Route::get('/category/edit/{id}', [CategoryController::class, 'categoryEdit'])->name('edit.category');
Route::post('/category/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('update.category');
Route::get('/category/destroy/{id}',[CategoryController::class,'categoryDestroy'])->name('destroy.category');

// User 

Route::get('/user', [UserController::class, 'users'])->name('user');
Route::get('/user/create',[UserController::class,'userCreate'])->name('create.user');
Route::post('/user/insert',[UserController::class,'userInsert'])->name('insert.user');
Route::get('/user/edit/{id}', [UserController::class, 'userEdit'])->name('edit.user');
Route::post('/user/update/{id}', [UserController::class, 'userUpdate'])->name('update.user');
Route::get('/user/destroy/{id}',[UserController::class,'userDestroy'])->name('destroy.user');

// Holiday

Route::get('/holiday', [HolidayController::class, 'Holiday'])->name('holiday');
Route::get('/holiday/create',[HolidayController::class,'holidayCreate'])->name('create.holiday');
Route::post('/holiday/insert',[HolidayController::class,'holidayInsert'])->name('insert.holiday');
Route::get('/holiday/edit/{id}', [HolidayController::class, 'holidayEdit'])->name('edit.holiday');
Route::post('/holiday/update/{id}', [HolidayController::class, 'holidayUpdate'])->name('update.holiday');
Route::get('/holiday/destroy/{id}',[HolidayController::class,'holidayDestroy'])->name('destroy.holiday');

//Role
Route::get('/role', [RoleController::class, 'role'])->name('role');
Route::get('/role/create', [RoleController::class, 'roleCreate'])->name('role.create');
Route::post('/role/store', [RoleController::class, 'roleStore'])->name('role.store');
Route::get('/role/edit/{id}', [RoleController::class, 'roleEdit'])->name('role.edit');
Route::post('/role/update/{id}', [RoleController::class, 'roleUpdate'])->name('role.update');
Route::delete('/role/delete/{id}', [RoleController::class, 'roleDestroy'])->name('role.destroy');

});




