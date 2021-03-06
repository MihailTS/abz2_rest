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
Route::group([
    'prefix' => 'v1',
], function () {
    Route::resource('employees', 'Employee\EmployeeController');
    Route::resource('employees.subordinates', 'Employee\EmployeeSubordinatesController', ['only' => 'index']);
    Route::resource('employees.position', 'Employee\EmployeePositionController', ['only' => 'index']);
    Route::resource('employees.head', 'Employee\EmployeeHeadController', ['only' => 'index']);

    Route::resource('positions', 'Position\PositionController');

    Route::resource('users', 'User\UserController');

    Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
    Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');
    Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
});