<?php

use Illuminate\Http\Request;

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

/*
//list of candidates
Route::get('candidates', 'CandidatesController@index');
//list of single candidate
Route::get('candidate/{id}', 'CandidatesController@show');
//store for candidate
Route::post('candidate', 'CandidatesController@store');
//update for candidate
Route::put('candidate/{id}', 'CandidatesController@update');
//delete for candidate
Route::delete('candidate/{id}', 'CandidatesController@destroy');
*/

Route::group(['middleware' => 'auth:api'],function() {
    Route::apiResource('candidate', 'CandidatesController');
});