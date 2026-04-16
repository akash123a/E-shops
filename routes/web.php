<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\FrontsiteController;

use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\BalanceController;
 

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontsiteController::class, 'home']);

Route::get('/admin/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/admin/register', [AuthController::class, 'register'])->name('register.post');


 

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');


// Protected Routes
Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

     // Change Password
    Route::get('/change-password', [AuthController::class, 'showChangePassword']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);


        Route::resource('sliders', SliderController::class);


  

    Route::get('/groups', [GroupController::class, 'index'])->name('group.index');
    Route::post('/groups/add-user', [GroupController::class, 'addUser'])->name('group.addUser');
    Route::post('/groups', [GroupController::class, 'store']);
    
// Show add user page
Route::get('/groups/{id}/add-user', [GroupController::class, 'showAddUserForm'])
    ->name('group.showAddUserForm');

// Add user to group
Route::post('/groups/add-user', [GroupController::class, 'addUser'])
    ->name('group.addUser');
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\GroupController::class, 'index'])
    ->name('admin.dashboard');

    Route::get('/expense/{group}', [ExpenseController::class, 'create'])->name('expense.form');

// Store expense
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expense.store');
Route::post('/expense/split/{id}', [ExpenseController::class, 'splitExpense'])->name('expense.split');


Route::get('/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
Route::post('/expense/update/{id}', [ExpenseController::class, 'update'])->name('expense.update');
Route::post('/expense/delete/{id}', [ExpenseController::class, 'destroy'])->name('expense.delete');
 

Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');



 
Route::post('/send-whatsapp/{groupId}', [ExpenseController::class, 'sendSettlementMessage'])
    ->name('send.whatsapp');

});

Route::get('/test-whatsapp', [ExpenseController::class, 'testWhatsApp']);