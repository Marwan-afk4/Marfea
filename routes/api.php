<?php

use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\CompanyController;
use App\Http\Controllers\Api\Admin\CountryController;
use App\Http\Controllers\Api\Admin\JobCetgoryController;
use App\Http\Controllers\Api\Admin\SpecializationController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ZoneController;
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
//users
    Route::get('/admin/getUsers',[UserController::class,'getUsers']);
    Route::put('/admin/editUser/{id}',[UserController::class,'editUser']);
    Route::put('/admin/deleteUser/{id}',[UserController::class,'deleteUser']);

//city
    Route::get('/admin/getCities',[CityController::class,'getCities']);
    Route::post('/admin/addCity',[CityController::class,'addCity']);
    Route::put('/admin/editCity/{id}',[CityController::class,'updateCity']);
    Route::delete('/admin/deleteCity/{id}',[CityController::class,'deleteCity']);

//country
    Route::get('/admin/getCountries',[CountryController::class,'getCountries']);
    Route::post('/admin/addCountry',[CountryController::class,'addCountry']);
    Route::put('/admin/editCountry/{id}',[CountryController::class,'editCountry']);
    Route::delete('/admin/deleteCountry/{id}',[CountryController::class,'deleteCountry']);

//zone
    Route::get('/admin/getZones',[ZoneController::class,'getZones']);
    Route::post('/admin/addZone',[ZoneController::class,'addZone']);
    Route::put('/admin/editZone/{id}',[ZoneController::class,'updateZone']);
    Route::delete('/admin/deleteZone/{id}',[ZoneController::class,'deleteZone']);

//jobCategory
    Route::get('/admin/getJobCategories',[JobCetgoryController::class,'getJobCategories']);
    Route::post('/admin/addJobCategory',[JobCetgoryController::class,'addJobCategory']);
    Route::put('/admin/editJobCategory/{id}',[JobCetgoryController::class,'updateJobCategory']);
    Route::delete('/admin/deleteJobCategory/{id}',[JobCetgoryController::class,'deleteJobCategory']);

//company
    Route::get('/admin/getCompanies',[CompanyController::class,'getCompanies']);
    Route::post('/admin/addCompany',[CompanyController::class,'addCompany']);
    Route::put('/admin/editCompany/{id}',[CompanyController::class,'updateCompany']);
    Route::delete('/admin/deleteCompany/{id}',[CompanyController::class,'deleteCompany']);

//specialization
    Route::get('/admin/getSpecializations',[SpecializationController::class,'getSpecializations']);
    Route::post('/admin/addSpecialization',[SpecializationController::class,'addSpecialization']);
    Route::put('/admin/editSpecialization/{id}',[SpecializationController::class,'updateSpecialization']);
    Route::delete('/admin/deleteSpecialization/{id}',[SpecializationController::class,'deleteSpecialization']);
});
