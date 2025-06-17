<?php

use App\Livewire\Admin\Auth\Login;
use App\Livewire\Edara\Auth\LoginEdara;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

 // edara routes
Route::group(['prefix' => 'edara' , ], function () {
    Route::get('/login', LoginEdara::class)->name('edara.login');
});


 // Lawyer routes
Route::group(['prefix' => 'lawyer'], function () {
});

// Client routes
Route::group(['prefix' => 'client'], function () {
});