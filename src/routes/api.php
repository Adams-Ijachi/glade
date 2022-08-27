<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Api\CompanyController;

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



//Route::group(['prefix' => 'v1'], function (){
//
//})

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function (){

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/create-company', [CompanyController::class, 'store']);
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::post('/company/{company}', [CompanyController::class, 'update']);
    Route::delete('/company/{company}', [CompanyController::class, 'destroy']);
    //getCompany
    Route::get('/getCompany', [CompanyController::class, 'getCompany']);

    Route::post('/create-employee', [EmployeeController::class, 'store']);
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employee/{employee}', [EmployeeController::class, 'update']);
    Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy']);
    Route::get('/getEmployees', [EmployeeController::class, 'getCompanyEmployees']);

    Route::post('/create-admin', [AdminController::class, 'store']);
    Route::get('/admins', [AdminController::class, 'index']);
    Route::post('/admin/{admin}', [AdminController::class, 'update']);
    Route::delete('/admin/{admin}', [AdminController::class, 'destroy']);


});
