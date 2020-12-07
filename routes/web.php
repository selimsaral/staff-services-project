<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\WorkController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes([
    'register' => false,
]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee-list');
        Route::post('/create', [EmployeeController::class, 'create'])->name('employee-create');
        Route::get('/show/{employee}', [EmployeeController::class, 'show'])->name('employee-show');
        Route::post('/update/{employee}', [EmployeeController::class, 'update'])->name('employee-update');
    });

    Route::group(['prefix' => 'job'], function () {
        Route::get('/', [WorkController::class, 'index'])->name('job-list');;
        Route::post('/create', [WorkController::class, 'create'])->name('job-create');
        Route::get('/show/{job}', [WorkController::class, 'show'])->name('job-show');
        Route::post('/update/{job}', [WorkController::class, 'update'])->name('job-update');
        Route::post('/get-counties', [WorkController::class, 'getCounties'])->name('get-counties');
    });

});
