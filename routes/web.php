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

Route::get('/admin/register', [AuthController::class, 'showRegister']);
Route::post('/admin/register', [AuthController::class, 'register']);


Route::get('/admin/login', [AuthController::class, 'showLogin']);
Route::post('/admin/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::get('/logout', [AuthController::class, 'logout']);

     // Change Password
    Route::get('/change-password', [AuthController::class, 'showChangePassword']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);


        Route::resource('sliders', SliderController::class);


  

    Route::get('/groups', [GroupController::class, 'index']);
    Route::post('/groups', [GroupController::class, 'store']);

    Route::post('/expenses', [ExpenseController::class, 'store']);

    Route::get('/balance/{groupId}', [BalanceController::class, 'show']);
 


});