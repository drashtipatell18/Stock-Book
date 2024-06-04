<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ScrapController;

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
Route::get('/forget-password', [DashboardController::class, 'showForgetPasswordForm'])->name('forget.password');
Route::post('/forget-password', [DashboardController::class, 'sendResetLinkEmail'])->name('forget.password.email');
Route::get('/reset/{token}', [DashboardController::class, 'reset'])->name('reset');
Route::post('/reset/{token}', [DashboardController::class, 'postReset'])->name('post_reset');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false
]);

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/cpassword',[HomeController::class,'cPassword'])->name('changepass');
Route::post('/changepassword',[HomeController::class,'changePassword'])->name('changePassword');

// Category

Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::get('/category/create', [CategoryController::class, 'createCategory'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('category.store');
Route::get('/category/edit/{id}', [CategoryController::class, 'categoryEdit'])->name('edit.category');
Route::post('/category/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('update.category');
Route::get('/category/destroy/{id}',[CategoryController::class,'categoryDestroy'])->name('destroy.category');


// Stall

Route::get('/stall', [StallController::class, 'stall'])->name('stall');
Route::get('/stall/create', [StallController::class, 'createStall'])->name('stall.create');
Route::post('/stall/store', [StallController::class, 'storeStall'])->name('stall.store');
Route::get('/stall/edit/{id}', [StallController::class, 'StallEdit'])->name('edit.stall');
Route::post('/stall/update/{id}', [StallController::class, 'StallUpdate'])->name('update.stall');
Route::get('/stall/destroy/{id}',[StallController::class,'StallDestroy'])->name('destroy.stall');

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

// Employee

Route::get('/employee', [EmployeeController::class, 'employees'])->name('employee');
Route::get('/employee/create',[EmployeeController::class,'employeeCreate'])->name('create.employee');
Route::post('/employee/insert',[EmployeeController::class,'employeeInsert'])->name('insert.employee');
Route::get('/employee/edit/{id}', [EmployeeController::class, 'employeeEdit'])->name('edit.employee');
Route::post('/employee/update/{id}', [EmployeeController::class, 'employeeUpdate'])->name('update.employee');
Route::get('/employee/destroy/{id}',[EmployeeController::class,'employeeDestroy'])->name('destroy.employee');
// Route::get('/my-profile', [EmployeeController::class, 'myProfile'])->name('my.profile');
// Route::get('/edit-profile/{id}', [EmployeeController::class, 'editProfile'])->name('edit-profile');
// Route::post('/update-profile/{id}', [EmployeeController::class, 'Profileupdate'])->name('update-profile');

// Book

Route::get('/book', [BookController::class, 'book'])->name('book');
Route::get('/book/create',[BookController::class,'bookCreate'])->name('create.book');
Route::post('/book/insert',[BookController::class,'bookInsert'])->name('insert.book');
Route::get('/book/edit/{id}', [BookController::class, 'bookEdit'])->name('edit.book');
Route::post('/book/update/{id}', [BookController::class, 'bookUpdate'])->name('update.book');
Route::get('/book/destroy/{id}',[BookController::class,'bookDestroy'])->name('destroy.book');

 //Payment

 Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
 Route::get('/payment/create',[PaymentController::class,'paymentCreate'])->name('create.payment');
 Route::post('/payment/insert',[PaymentController::class,'paymentInsert'])->name('insert.payment');
 Route::get('/payment/edit/{id}', [PaymentController::class, 'paymentEdit'])->name('edit.payment');
 Route::post('/payment/update/{id}', [PaymentController::class, 'paymentUpdate'])->name('update.payment');
 Route::get('/payment/destroy/{id}',[PaymentController::class,'paymentDestroy'])->name('destroy.payment');

  //Sales Order

  Route::get('/salesorder', [SalesOrderController::class, 'salesorder'])->name('salesorder');
  Route::get('/salesorder/create',[SalesOrderController::class,'salesorderCreate'])->name('create.salesorder');
  Route::post('/salesorder/insert',[SalesOrderController::class,'salesorderInsert'])->name('insert.salesorder');
  Route::get('/salesorder/edit/{id}', [SalesOrderController::class, 'salesorderEdit'])->name('edit.salesorder');
  Route::post('/salesorder/update/{id}', [SalesOrderController::class, 'salesorderUpdate'])->name('update.salesorder');
  Route::get('/salesorder/destroy/{id}',[SalesOrderController::class,'salesorderDestroy'])->name('destroy.salesorder');


  //Scrap

  Route::get('/scrap', [ScrapController::class, 'scrap'])->name('scrap');
  Route::get('/scrap/create',[ScrapController::class,'scrapCreate'])->name('create.scrap');
  Route::post('/scrap/insert',[ScrapController::class,'scrapInsert'])->name('insert.scrap');
  Route::get('/scrap/edit/{id}', [ScrapController::class, 'scrapEdit'])->name('edit.scrap');
  Route::post('/scrap/update/{id}', [ScrapController::class, 'sscrapUpdate'])->name('update.scrap');
  Route::get('/scrap/destroy/{id}',[ScrapController::class,'scrapDestroy'])->name('destroy.scrap');

});




