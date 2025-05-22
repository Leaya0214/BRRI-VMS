<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\CompanyInfoController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\NoticeController;

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

Route::post('login', [LoginController::class, 'login']);
Route::post('password/request/otp', [ResetPasswordController::class, 'requestOtp']);
Route::post('password/reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::get('vehicle/type', [VehicleController::class, 'vehicleType']);
Route::get('district', [EmployeeController::class, 'getAllDistrict']);
Route::get('division', [EmployeeController::class, 'getAllDivision']);
Route::get('division/{id}/district', [EmployeeController::class, 'divisionwiseDistrict']);
Route::get('driver/list', [EmployeeController::class, 'driverList']);
Route::get('employee/list', [EmployeeController::class, 'getAllEmployee']);
Route::get('section/list', [EmployeeController::class, 'getAllSection']);
Route::get('section/employee/{id}/list', [EmployeeController::class, 'sectionwiseEmployee']);
Route::get('vehicle/list', [EmployeeController::class, 'vehicleList']);
Route::get('brri/info', [CompanyInfoController::class, 'systemInfo']);
Route::get('slider/list', [SliderController::class, 'getSlider']);
Route::get('notice/list', [NoticeController::class, 'getNoticeList']);
Route::get('requisition/pdf/{requisition_id}', [VehicleController::class, 'generatePdfAndSendLink']);



Route::middleware(['employeeApi'])->group(function () {
    Route::get('profile', [EmployeeController::class, 'employeeProfile']);
    Route::post('image/update', [EmployeeController::class, 'updateProfileImage']);
    Route::post('signature/update', [EmployeeController::class, 'updateSignature']);
    Route::post('requisition/submit', [VehicleController::class, 'submitRequisition']);
    Route::get('employee/requisition/list', [VehicleController::class, 'showEmployeeRequisitionList']);
    Route::get('requisition/list/head', [VehicleController::class, 'staffRequisitionAtDeptHead']);
    Route::get('/requisition/list/director', [VehicleController::class, 'staffRequisitionAtDirector']);
    Route::get('employee/requisition/list/dgm', [VehicleController::class, 'staffRequisitionAtDGM']);
    Route::get('employee/requisition/list/tso', [VehicleController::class, 'staffRequisitionAtTSO']);
    Route::post('requisition/forward/dg/dir', [VehicleController::class, 'forwardToDgOrDir']);
    Route::post('requisition/forward/tso', [VehicleController::class, 'forward']);
    Route::post('requisition/approve/tso', [VehicleController::class, 'approvedByTSO']);
    Route::post('vehicle/assign/{id}', [VehicleController::class, 'assignVehicle']);
    Route::post('vehicle/assign/{id}', [VehicleController::class, 'assignVehicle']);
    Route::post('reject/requisition', [VehicleController::class, 'rejectRequisition']);
});


