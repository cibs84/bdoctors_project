<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sponsored-users', 'Api\UserController@getSponsoredUsers');
Route::get('/users-by-specialization/{specialization_slug}', 'Api\UserController@getUsersBySpecialization');
Route::get('/users-by-specialization-and-average-vote/{specialization_slug}/{filter_avg_vote}', 'Api\UserController@getUsersBySpecAndAvgVote');
Route::get('/users-by-specialization-and-count-reviews/{specialization_slug}/{reviews_min}/{reviews_max}', 'Api\UserController@getUsersBySpecAndCountRev');

Route::get('/users/{user_slug}', 'Api\UserController@show');

Route::post('/messages', 'Api\MessageController@store');

Route::post('/reviews', 'Api\ReviewController@store');

// Route::get('/reviews/{slug}', 'Api\ReviewController@show');


