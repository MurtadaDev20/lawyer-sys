<?php

use App\Http\Middleware\EnsureEdaraIsAuthenticated;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Edara\Auth\LoginEdara;
use App\Livewire\Edara\Auth\OtpVerification;
use App\Livewire\Edara\Auth\ResetPassword;
use App\Livewire\Edara\Main\Customer;
use App\Livewire\Edara\Main\Dashboard;
use App\Livewire\Edara\Main\Lawyer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

 // edara routes
Route::group(['prefix' => 'edara',], function () {

    //Authentication routes
    Route::group(['prefix' => 'auth' , ], function () {
        Route::get('/login', LoginEdara::class)->name('edara.login');
        Route::get('/reset-password',ResetPassword::class)->name('edara.reset-password');
        Route::get('/otp-verification',OtpVerification::class)->name('edara.otp-verification')->middleware('auth');
    });

    // Admin routes
    Route::middleware([EnsureEdaraIsAuthenticated::class])->group( function () {
        Route::get('/dashboard', Dashboard::class)->name('edara.dashboard');
        Route::get('/lawyer-manage', Lawyer::class)->name('edara.lawyerManage');
        Route::get('/customer-manage', Customer::class)->name('edara.customerManage');
    });
});


 // Lawyer routes
Route::group(['prefix' => 'lawyer'], function () {
});

// Client routes
Route::group(['prefix' => 'client'], function () {
});