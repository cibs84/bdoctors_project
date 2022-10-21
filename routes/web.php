<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Auth::routes();

Route::middleware('auth')
     ->namespace('Admin')
     ->name('admin.')
     ->prefix('admin')
     ->group(function() {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('users', 'UserController');
        Route::resource('messages', 'MessageController');
        Route::resource('reviews', 'ReviewController');
    });

// DEBUG
Route::get('/debug', 'HomeController@debug')->name('debug');


// STATISTICS ROUTE
Route::get('/statistics', 'Admin\StatisticController@getStatisticsUser')->name('statistics');

// Rotte gestite da Vue
// SPONSOR
Route::get('/sponsors', 'Admin\SponsorController@getSponsorPackages')->name('sponsor');

// PAYMENT PROCESS
// route per la view con il form del pagamento
Route::post('/payment/form', 'Admin\PaymentsController@paymentForm')->name('payment.form');
// route per avviare tutto il processo di transazione verso braintree
Route::post('/payment/process', 'Admin\PaymentsController@process')->name('payment.process');

Route::get('{any?}', function () {
    return view('guest.home');
})->where('any', '.*')->name('guest');

