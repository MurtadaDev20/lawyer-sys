<?php

use App\Livewire\Admin\Auth\Login;
use App\Livewire\Lawery\Main\File;
use App\Livewire\Edara\Main\Lawyer;
use App\Livewire\Edara\Main\Customer;
use App\Livewire\Lawery\Main\Archive;
use Illuminate\Support\Facades\Route;
use App\Livewire\Edara\Main\Dashboard;
use App\Livewire\Edara\Auth\LoginEdara;
use App\Livewire\Lawery\Main\CaseLawyer;
use App\Livewire\Lawery\Auth\LoginLawyer;
use App\Livewire\Lawery\Main\CaseDetails;
use App\Livewire\Lawery\Main\FilePreview;
use App\Livewire\Edara\Auth\ResetPassword;
use App\Livewire\Edara\Auth\OtpVerification;
use App\Livewire\Lawery\Main\CustomerManage;
use App\Livewire\Customer\Auth\LoginCustomer;
use App\Livewire\Lawery\Main\DashboardLawyer;
use App\Http\Middleware\EnsureEdaraIsAuthenticated;
use App\Http\Middleware\EnsureLawyerIsAuthenticated;
use App\Http\Middleware\EnsureCustomerIsAuthenticated;
use App\Livewire\Customer\Main\CasessCustomer;
use App\Livewire\Customer\Main\DashboardCustomer;

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
    Route::group(['prefix' => 'auth' , ], function () {
        Route::get('/login', LoginLawyer::class)->name('lawyer.login');
        Route::get('/reset-password',ResetPassword::class)->name('lawyer.reset-password');
        Route::get('/otp-verification',OtpVerification::class)->name('lawyer.otp-verification')->middleware('auth');
    });
    // Add more lawyer-specific routes here

    Route::middleware([EnsureLawyerIsAuthenticated::class])->group( function () {
        Route::get('/dashboard', DashboardLawyer::class)->name('lawyer.dashboard');
        Route::get('/archive', Archive::class)->name('lawyer.archive');
        Route::get('/files/{id}', File::class)->name('lawyer.file');
        Route::get('/files/preview/{id}', FilePreview::class)->name('file.preview');

        //customer management routes
        Route::get('/customer-manage', CustomerManage::class)->name('lawyer.customerManage');
        Route::get('/case-lawer/{id}', CaseLawyer::class)->name('lawyer.case-lawyer');
        Route::get('/case-details/{id}', CaseDetails::class)->name('lawyer.case-details');

    });
});

// Client routes
Route::group(['prefix' => 'customer'], function () {
        Route::group(['prefix' => 'auth' , ], function () {
            Route::get('/login', LoginCustomer::class)->name('customer.login');
            Route::get('/reset-password',ResetPassword::class)->name('lawyer.reset-password');
            Route::get('/otp-verification',OtpVerification::class)->name('lawyer.otp-verification')->middleware('auth');
    });

    // Add more customer-specific routes here
    Route::middleware([EnsureCustomerIsAuthenticated::class])->group( function () {
        Route::get('/dashboard', DashboardCustomer::class)->name('customer.dashboard');
        Route::get('/casess', CasessCustomer::class)->name('customer.case');

    });
});