<?php

use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\CompanyController;
use App\Http\Controllers\Api\Admin\CompanyTypeController;
use App\Http\Controllers\Api\Admin\CountryController;
use App\Http\Controllers\Api\Admin\DrugCategoryController;
use App\Http\Controllers\Api\Admin\DrugsController;
use App\Http\Controllers\Api\Admin\HomePageController as AdminHomePageController;
use App\Http\Controllers\Api\Admin\JobCetgoryController;
use App\Http\Controllers\Api\Admin\JobOfferController;
use App\Http\Controllers\Api\Admin\JobTittleController;
use App\Http\Controllers\Api\Admin\PendingEmployeerController;
use App\Http\Controllers\Api\Admin\PlansController;
use App\Http\Controllers\Api\Admin\SpecializationController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ZoneController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Employeer\ChangePsswordController;
use App\Http\Controllers\Api\Employeer\HomePageController;
use App\Http\Controllers\Api\Employeer\JobController;
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

//JobOffer
    Route::get('/admin/getJobs',[JobOfferController::class,'getJobs']);
    Route::post('/admin/addJob',[JobOfferController::class,'addJob']);
    Route::put('/admin/editJob/{id}',[JobOfferController::class,'editJob']);
    Route::delete('/admin/deleteJob/{id}',[JobOfferController::class,'deleteJob']);

//CompanyType
    Route::get('/admin/getCompanyTypes',[CompanyTypeController::class,'getCompanyTypes']);
    Route::get('/admin/getActiveCompanyTypes',[CompanyTypeController::class,'getActiveCompanyTypes']);
    Route::post('/admin/addCompanyType',[CompanyTypeController::class,'addCompanyType']);
    Route::put('/admin/editCompanyType/{id}',[CompanyTypeController::class,'editCompanyType']);
    Route::delete('/admin/deleteCompanyType/{id}',[CompanyTypeController::class,'deleteCompanyType']);

//JobTittle
    Route::get('/admin/getJobTitles',[JobTittleController::class,'getJobTittles']);
    Route::get('/admin/getActiveJobTittles',[JobTittleController::class,'getActiveJobTittles']);
    Route::post('/admin/addJobTittle',[JobTittleController::class,'addJobTitel']);
    Route::put('/admin/editJobTittle/{id}',[JobTittleController::class,'updateJobTitel']);
    Route::delete('/admin/deleteJobTittle/{id}',[JobTittleController::class,'deleteJobTitel']);

//Drugs
    Route::get('/admin/getDrugs',[DrugsController::class,'getDrugs']);
    Route::post('/admin/addDrug',[DrugsController::class,'createDrug']);
    Route::put('/admin/editDrug/{id}',[DrugsController::class,'updateDrug']);
    Route::delete('/admin/deleteDrug/{id}',[DrugsController::class,'destroyDrug']);

//Drug Category
    Route::get('/admin/getDrugCategories',[DrugCategoryController::class,'getDrugCtegory']);
    Route::post('/admin/addDrugCategory',[DrugCategoryController::class,'addDrugCategory']);
    Route::put('/admin/editDrugCategory/{id}',[DrugCategoryController::class,'editDrugCategory']);
    Route::delete('/admin/deleteDrugCategory/{id}',[DrugCategoryController::class,'deleteDrugCategory']);

//Plans
    Route::get('/admin/getPlans',[PlansController::class,'getPlans']);
    Route::post('/admin/addPlan',[PlansController::class,'createPlan']);
    Route::put('/admin/editPlan/{id}',[PlansController::class,'updatePlan']);
    Route::delete('/admin/deletePlan/{id}',[PlansController::class,'destroy']);

//Pending Employeer
    Route::get('/admin/getPendingEmployeer',[PendingEmployeerController::class,'getPendingEmployeerRequest']);
    Route::get('/admin/getApprovedEmployeer',[PendingEmployeerController::class,'getApprovedEmployeerRequest']);
    Route::get('/admin/getRejectedEmployeer',[PendingEmployeerController::class,'getRejectedEmployeerRequest']);
    Route::put('/admin/acceptPendingEmployeer/{id}',[PendingEmployeerController::class,'approvePendingEmployeerRequest']);
    Route::put('/admin/rejectPendingEmployeer/{id}',[PendingEmployeerController::class,'rejectPendingEmployeerRequest']);

//HomePage
    Route::get('/admin/homePage',[AdminHomePageController::class,'homePage']);
});




Route::middleware(['auth:sanctum','IsEmployeer'])->group(function () {
// Home Page
    Route::get('/employeer/homePage',[HomePageController::class,'homePage']);

//change password
    Route::put('/employeer/changePassword',[ChangePsswordController::class,'changePassword']);

//jobs
    Route::get('/employeer/getJobs',[JobController::class,'getJobs']);
    Route::post('/employeer/addNewJob',[JobController::class,'addNewJob']);
    Route::put('/employeer/editJob/{id}',[JobController::class,'editJob']);
    Route::delete('/employeer/deleteJob/{id}',[JobController::class,'deleteJob']);
});
