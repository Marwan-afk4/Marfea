<?php

use App\Http\Controllers\Api\Admin\CityController;
use App\Http\Controllers\Api\Admin\CompanyController;
use App\Http\Controllers\Api\Admin\CompanyTypeController;
use App\Http\Controllers\Api\Admin\ContactsController;
use App\Http\Controllers\Api\Admin\CountryController;
use App\Http\Controllers\Api\Admin\DrugCategoryController;
use App\Http\Controllers\Api\Admin\DrugsController;
use App\Http\Controllers\Api\Admin\HomePageController as AdminHomePageController;
use App\Http\Controllers\Api\Admin\JobCetgoryController;
use App\Http\Controllers\Api\Admin\JobOfferController;
use App\Http\Controllers\Api\Admin\JobTittleController;
use App\Http\Controllers\Api\Admin\PatmentRequestsController;
use App\Http\Controllers\Api\Admin\PaymentMethodController;
use App\Http\Controllers\Api\Admin\PendingEmployeerController;
use App\Http\Controllers\Api\Admin\PlansController;
use App\Http\Controllers\Api\Admin\SpecializationController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\ZoneController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Employeer\ChangePsswordController;
use App\Http\Controllers\Api\Employeer\HomePageController;
use App\Http\Controllers\Api\Employeer\JobController;
use App\Http\Controllers\Api\Employeer\JobSuppliersController;
use App\Http\Controllers\Api\Employeer\LocationController;
use App\Http\Controllers\Api\Employeer\PaymentController;
use App\Http\Controllers\Api\Employeer\PaymentMethodController as EmployeerPaymentMethodController;
use App\Http\Controllers\Api\Employeer\TrackCvApplicationsController;
use App\Http\Controllers\Api\User\CompanyController as UserCompanyController;
use App\Http\Controllers\Api\User\ContactUsController;
use App\Http\Controllers\Api\User\DrugsController as UserDrugsController;
use App\Http\Controllers\Api\User\JobApplicationController;
use App\Http\Controllers\Api\User\JobsController;
use App\Http\Controllers\Api\User\ProfileController;
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
    Route::post('/admin/addUser',[UserController::class,'addUser']);
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

//PaymentMethods
    Route::get('/admin/getPaymentMethods',[PaymentMethodController::class,'getPyamentMethod']);
    Route::post('/admin/addPaymentMethod',[PaymentMethodController::class,'addPaymentMethod']);
    Route::put('/admin/editPaymentMethod/{id}',[PaymentMethodController::class,'editPaymentMethod']);
    Route::delete('/admin/deletePaymentMethod/{id}',[PaymentMethodController::class,'deletePaymentMethod']);

//HomePage
    Route::get('/admin/homePage',[AdminHomePageController::class,'homePage']);

//pendingPyament
    Route::get('/admin/getPendingPyament',[PatmentRequestsController::class,'getPendingPaymentRequests']);
    Route::get('/admin/getApprovedPyament',[PatmentRequestsController::class,'getApprovedPaymentRequests']);
    Route::get('/admin/getRejectedPyament',[PatmentRequestsController::class,'getRejectedPaymentRequests']);
    Route::put('/admin/acceptPendingPyament/{id}',[PatmentRequestsController::class,'acceptPaymentRequests']);
    Route::put('/admin/rejectPendingPyament/{id}',[PatmentRequestsController::class,'rejectPaymentRequests']);

//ContactsRequest
    Route::get('/admin/getContactsRequests',[ContactsController::class,'getContacts']);
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

//Plans
    Route::get('/employeer/getPlans',[PaymentController::class,'getPlans']);

//PlanPayment
    Route::post('/employeer/makePlanPyament',[PaymentController::class,'makePlanPyament']);

//PayementMethods
    Route::get('/employeer/getPaymentMethods',[EmployeerPaymentMethodController::class,'getActivePaymentMethod']);

//JobTittle
    Route::get('/employeer/getActiveJobTittles',[JobSuppliersController::class,'getActiveJobTittles']);

//JobCategory
    Route::get('/employeer/getJobCategories',[JobSuppliersController::class,'getJobCategories']);

//City
    Route::get('/employeer/getCities',[LocationController::class,'getActiveCities']);

//Zone
    Route::get('/employeer/getZones',[LocationController::class,'getActiveZones']);

//TrackCv
    Route::get('/employeer/get-trackcvs',[TrackCvApplicationsController::class,'getApplicationsForCompany']);
});





Route::middleware(['auth:sanctum','IsUser'])->group(function () {

//Profile
    Route::get('/user/profile',[ProfileController::class,'getProfileData']);
    Route::put('/user/profile/update',[ProfileController::class,'updateProfileData']);
    Route::get('/user/specializations/get',[ProfileController::class,'getSpecializations']);
    Route::delete('/user/profile/delete',[ProfileController::class,'deleteAccount']);

//Company
    Route::get('/user/getCompanies',[UserCompanyController::class,'getCompanies']);
    Route::post('/user/search-company',[UserCompanyController::class,'searchCompanies']);
    Route::get('/user/get-countries',[UserCompanyController::class,'getCountries']);

//drugs
    Route::get('/user/getDrugs',[UserDrugsController::class,'getAllDrugs']);

//Jobs
    Route::get('/user/getJobs',[JobsController::class,'getAllJobs']);
    Route::post('/user/job-search',[JobsController::class,'jobSearch']);
    Route::get('/user/jobfilterids',[JobsController::class,'getIdsForJobSearch']);

//Contact Us
    Route::post('/user/sendMessage',[ContactUsController::class,'contactUs']);

//JobApplication
    Route::post('/user/apply-job',[JobApplicationController::class,'applyToJob']);
    Route::get('/user/get-usercv',[JobApplicationController::class,'getUserCv']);
    Route::get('/user/my-applications',[JobApplicationController::class,'myApplications']);
});
