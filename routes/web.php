<?php

use App\Http\Middleware\EnsureEdaraIsAuthenticated;
use App\Http\Middleware\EnsureLawyerIsAuthenticated;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Edara\Auth\LoginEdara;
use App\Livewire\Edara\Auth\OtpVerification;
use App\Livewire\Edara\Auth\ResetPassword;
use App\Livewire\Edara\Main\Customer;
use App\Livewire\Edara\Main\Dashboard;
use App\Livewire\Edara\Main\Lawyer;
use App\Livewire\Lawery\Auth\LoginLawyer;
use App\Livewire\Lawery\Main\Archive;
use App\Livewire\Lawery\Main\DashboardLawyer;
use App\Livewire\Lawery\Main\File;
use App\Livewire\Lawery\Main\FilePreview;
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
        Route::get('/files/preview/{file}', FilePreview::class)->name('file.preview');


        // Add more lawyer-specific routes here
    });
});

// Client routes
Route::group(['prefix' => 'client'], function () {
});