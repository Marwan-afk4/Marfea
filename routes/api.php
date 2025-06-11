<?php

use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/registerUser',[AuthController::class,'registerUser']);
Route::post('/verifyOtp',[AuthController::class,'verifyOtp']);
Route::get('/getCompanies',[AuthController::class,'getCompanies']);
Route::post('/registerEmployeer',[AuthController::class,'registerEmployeer']);
Route::post('/addCompanyNewData',[AuthController::class,'addCompanyNewData']);
Route::post('/login',[AuthController::class,'login']);


Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {

    Route::get('/admin/getUsers',[UserController::class,'getUsers']);
    Route::put('/admin/editUser/{id}',[UserController::class,'editUser']);
    Route::put('/admin/deleteUser/{id}',[UserController::class,'deleteUser']);
});
