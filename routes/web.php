<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\FrontsiteController;


use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\BalanceController;
use App\Http\Controllers\Admin\NavbarController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
 

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
 
 
Route::resource('users', App\Http\Controllers\Admin\UserController::class);

 
Route::post('/send-whatsapp/{groupId}', [ExpenseController::class, 'sendSettlementMessage'])
    ->name('send.whatsapp');


       Route::get('/navbar', [NavbarController::class, 'index'])->name('navbar.index');

    Route::post('/navbar', [NavbarController::class, 'store'])->name('navbar.store');

    Route::get('/navbar/edit/{id}', [NavbarController::class, 'edit'])->name('navbar.edit');

    Route::post('/navbar/update/{id}', [NavbarController::class, 'update'])->name('navbar.update');

    Route::get('/navbar/delete/{id}', [NavbarController::class, 'delete'])->name('navbar.delete');
    Route::post('/admin/navbar/reorder', [NavbarController::class, 'reorder'])->name('navbar.reorder');


     Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/create', [SettingController::class, 'create'])->name('settings.create');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

    Route::get('/settings/{id}/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{id}', [SettingController::class, 'update'])->name('settings.update');

    Route::delete('/settings/{id}', [SettingController::class, 'destroy'])->name('settings.delete');

     Route::get('/pages', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [App\Http\Controllers\Admin\PageController::class, 'create'])->name('pages.create');
    Route::post('/pages/store', [App\Http\Controllers\Admin\PageController::class, 'store'])->name('pages.store');

    Route::get('/pages/edit/{id}', [App\Http\Controllers\Admin\PageController::class, 'edit'])->name('pages.edit');
    Route::post('/pages/update/{id}', [App\Http\Controllers\Admin\PageController::class, 'update'])->name('pages.update');

    Route::get('/pages/delete/{id}', [App\Http\Controllers\Admin\PageController::class, 'delete'])->name('pages.delete');
 

});

Route::get('/test-whatsapp', [ExpenseController::class, 'testWhatsApp']);

Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');


Route::get('/test-mail', function () {
    Mail::raw('Test Email Working!', function ($message) {
        $message->to('hamzadevops123@gmail.com')
                ->subject('Test Mail');
    });

    return "Mail Sent from local !";
});