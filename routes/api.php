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


Route::get('contacts', 'ContactController@index');
Route::get('contact/{id}', 'ContactController@edit');
 Route::post('contact/store', 'ContactController@store');
 Route::patch('contact/{id}', 'ContactController@update');
Route::delete('contact/{id}', 'ContactController@destroy');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
