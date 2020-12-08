<?php

use App\Http\Controllers\EmployeeController;
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


Route::group(['prefix' => 'employee'], function () {
    Route::post('login', [EmployeeController::class, 'login']);

    Route::group(['middleware' => 'auth:api_token'], function () {
        Route::get('job-list', [EmployeeController::class, 'jobList']);
        Route::post('job-update-status/{job}', [EmployeeController::class, 'updateJobStatus']);
        Route::post('job-create', [EmployeeController::class, 'createJob']);
    });
});
