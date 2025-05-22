<?php

use App\Models\SecurityMoney;
use App\Models\FundCurrentBalance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\VehicleExpenseCategory;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\CheckUserTypeController;
use App\Http\Controllers\Employee\EmployeePanelController;
use App\Http\Controllers\VehicleManagement\VehicleController;
use App\Http\Controllers\VehicleManagement\VehicleTypeController;
use App\Http\Controllers\VehicleManagement\ExpenseDetailsController;
use App\Http\Controllers\VehicleManagement\VehicleExpenseHeadController;
use App\Http\Controllers\VehicleManagement\VehicleRequisitionController;
use App\Http\Controllers\VehicleManagement\VehicleExpenseCategoryController;

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

Route::get('/', function () {
    return redirect('home'); // Redirects to '/login/employee'
});

Route::get('/login/employee', [CheckUserTypeController::class, 'employeeLogin'])->name('checkUser');
Route::post('/submitLogin', [CheckUserTypeController::class, 'submitLogin'])->name('submitLogin');
Route::post('/submitLogout', [CheckUserTypeController::class, 'logout'])->name('submitLogout');


Route::get('/profile', [EmployeePanelController::class, 'profile'])->name('employee.profile');
Route::get('/profile_view', [EmployeePanelController::class, 'profile_view'])->name('employee.profile_view');
Route::get('/employee_notice', [EmployeePanelController::class, 'notices'])->name('employee_notices');
Route::post('/upload_image/{id}', [EmployeePanelController::class, 'upload_image'])->name('employee_profile_photo');
Route::post('/update_signature/{id}', [EmployeePanelController::class, 'update_signature'])->name('employee_update_signature');



//Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function() {
    Route::get('/select-company/{id}', [HomeController::class, 'select_company'])->name('select-company');

    /** user section  */
    Route::get('/user-permission', [UserController::class, 'permission'])->name('user-permission');
    Route::get('/select-user-menu/{id}', [UserController::class, 'user_menu'])->name('select-user-menu');
    Route::post('/save-permission', [UserController::class, 'save_permission'])->name('save-permission');
    Route::get('/user-list', [UserController::class, 'index'])->name('user-list');
    Route::post('/save-user', [UserController::class, 'store'])->name('save-user');
    Route::get('/change-user-status/{status}/{id}',[UserController::class,'status_update'])->name('change-user-status');
    Route::post('/update-user', [UserController::class, 'update'])->name('update-user');

    /** District Routes */

     Route::get('/district',[DistrictController::class,'index'])->name('district');
     Route::post('/district/store',[DistrictController::class,'store'])->name('district-store');
     Route::post('/district/update/{id}',[DistrictController::class,'update'])->name('district-update');
     Route::get('/district/delete/{id}',[DistrictController::class,'delete'])->name('district-delete');


     /** division */
        Route::get('/division-list', [DivisionController::class, 'index'])->name('division-list');
        Route::post('/save-division', [DivisionController::class, 'store'])->name('save-division');
        Route::get('/change-division-status/{status}/{id}', [DivisionController::class, 'status_update'])->name('change-division-status');
        Route::post('/update-division', [DivisionController::class, 'update'])->name('update-division');




    /** section section */
    Route::get('/section-list', [SectionController::class, 'index'])->name('section-list');
    Route::post('/save-section', [SectionController::class, 'store'])->name('save-section');
    Route::get('/change-section-status/{status}/{id}',[SectionController::class,'status_update'])->name('change-section-status');
    Route::post('/update-section', [SectionController::class, 'update'])->name('update-section');





    /** designation section */
    Route::get('/designation-list', [DesignationController::class, 'index'])->name('designation-list');
    Route::post('/save-designation', [DesignationController::class, 'store'])->name('save-designation');
    Route::get('/change-designation-status/{status}/{id}',[DesignationController::class,'status_update'])->name('change-designation-status');
    Route::post('/update-designation', [DesignationController::class, 'update'])->name('update-designation');
    Route::get('/designations-by-section/{section_id}', [DesignationController::class, 'getDesignationsBySection']);


    /** Employee section */
    Route::get('/employee-create', [EmployeeController::class, 'create'])->name('employee-create');
    Route::post('/search-employee', [EmployeeController::class, 'search'])->name('search-employee');
    Route::post('/save-employee', [EmployeeController::class, 'store'])->name('save-employee');
    Route::get('/manage-employee', [EmployeeController::class, 'index'])->name('manage-employee');
    Route::get('/load_employee_view/{id}', [EmployeeController::class, 'load_employee_view'])->name('load_employee_view');
    Route::get('/edit-employee/{id}', [EmployeeController::class, 'edit'])->name('edit-employee');
    Route::post('/update-employee', [EmployeeController::class, 'update'])->name('update-employee');
    Route::get('/employee-profile/{id}', [EmployeeController::class, 'profile'])->name('employee-profile');
    Route::post('employee/import', [EmployeeController::class, 'import'])->name('employee.import');



    Route::get('/manage-driver', [EmployeeController::class, 'driverList'])->name('manage-driver');
    Route::get('/create-driver', [EmployeeController::class, 'createDriver'])->name('create-driver');
    Route::get('/edit-driver/{id}', [EmployeeController::class, 'editDriver'])->name('edit-driver');

    Route::get('/load_department_by_company_id/{id}', [EmployeeController::class, 'load_department_by_company_id'])->name('load_department_by_company_id');
    Route::get('/load_section_by_company_id/{id}', [EmployeeController::class, 'load_section_by_company_id'])->name('load_section_by_company_id');
    Route::get('/load_branch_by_company_id/{id}', [EmployeeController::class, 'load_branch_by_company_id'])->name('load_branch_by_company_id');
    Route::get('/change-employee-status/{status}/{id}',[EmployeeController::class,'status_update'])->name('change-employee-status');



    Route::get('/slider', [SliderController::class, 'index'])->name('sliders');
    Route::post('/slider/store', [SliderController::class, 'store'])->name('sliders-store');
    Route::put('/slider/update/{id}', [SliderController::class, 'update'])->name('sliders-update');
    Route::get('/slider/delete/{id}', [SliderController::class, 'delete'])->name('sliders-delete');


  /** company section */
    Route::get('/company-list', [CompanyController::class, 'index'])->name('company-list');
    Route::post('/save-company', [CompanyController::class, 'store'])->name('save-company');
    Route::get('/change-company-status/{status}/{id}',[CompanyController::class,'status_update'])->name('change-company-status');
    Route::post('/update-company', [CompanyController::class, 'update'])->name('update-company');

    Route::get('/vehicle-type', [VehicleTypeController::class, 'index'])->name('vehicle-types');
    Route::post('/vehicle-type/store', [VehicleTypeController::class, 'store'])->name('vehicle-types-store');
    Route::post('/vehicle-type/update/{id}', [VehicleTypeController::class, 'update'])->name('vehicle-types-update');
    Route::get('/vehicle-type/delete/{id}', [VehicleTypeController::class, 'delete'])->name('vehicle-types-delete');


    Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicles');
    Route::get('/setup-vehicle', [VehicleController::class, 'setup'])->name('vehicles-setup');
    Route::get('vehicle/edit/{id}', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::post('/vehicle/store', [VehicleController::class, 'store'])->name('vehicles-store');
    Route::put('/vehicle/update/{id}', [VehicleController::class, 'update'])->name('vehicles-update');
    Route::get('/vehicle/delete/{id}', [VehicleController::class, 'delete'])->name('vehicles-delete');

    Route::get('/driver', [DriverController::class, 'index'])->name('drivers');
    Route::post('/driver/store', [DriverController::class, 'store'])->name('drivers-store');
    Route::put('/driver/update/{id}', [DriverController::class, 'update'])->name('drivers-update');
    Route::get('/driver/delete/{id}', [DriverController::class, 'delete'])->name('drivers-delete');


    Route::get('/notice', [NoticeController::class, 'index'])->name('notices');
    Route::post('/notice/store', [NoticeController::class, 'store'])->name('notices-store');
    Route::put('/notice/update/{id}', [NoticeController::class, 'update'])->name('notices-update');
    Route::get('/notice/delete/{id}', [NoticeController::class, 'delete'])->name('notices-delete');



    Route::get('/vehicle-expense-category', [VehicleExpenseCategoryController::class, 'index'])->name('vehicle-expense-categories');
    Route::post('/vehicle-expense-category/store', [VehicleExpenseCategoryController::class, 'store'])->name('vehicle-expense-categories-store');
    Route::put('/vehicle-expense-category/update/{id}', [VehicleExpenseCategoryController::class, 'update'])->name('vehicle-expense-categories-update');
    Route::get('/vehicle-expense-category/delete/{id}', [VehicleExpenseCategoryController::class, 'delete'])->name('vehicle-expense-categories-delete');

    Route::get('/vehicle-expense-head', [VehicleExpenseHeadController::class, 'index'])->name('vehicle-expense-heads');
    Route::post('/vehicle-expense-head/store', [VehicleExpenseHeadController::class, 'store'])->name('vehicle-expense-heads-store');
    Route::put('/vehicle-expense-head/update/{id}', [VehicleExpenseHeadController::class, 'update'])->name('vehicle-expense-heads-update');
    Route::get('/vehicle-expense-head/delete/{id}', [VehicleExpenseHeadController::class, 'delete'])->name('vehicle-expense-heads-delete');

    Route::get('/add-expense-details', [ExpenseDetailsController::class, 'addExpense'])->name('expense-details-add');
    Route::get('/expense-details', [ExpenseDetailsController::class, 'index'])->name('expense-details-index');
    Route::post('/expense-details/store', [ExpenseDetailsController::class, 'store'])->name('expense-details-store');
    Route::get('expense-details/edit/{id}', [ExpenseDetailsController::class, 'edit'])->name('expense-details-edit');
    Route::put('/expense-details/update/{id}', [ExpenseDetailsController::class, 'update'])->name('expense-details-update');
    Route::get('/get-expense-head/{category_id}', [ExpenseDetailsController::class, 'getExpenseHead'])->name('get.expense-head');

    Route::get('/vehicle-requisition-list', [VehicleRequisitionController::class, 'allEmployeeRequisitionList'])->name('vehicle.requisition.list');


});

//Reuisition Route
Route::get('/vehicle-requisition', [VehicleRequisitionController::class, 'requisitionFrom'])->name('vehicle.requisition.form');
Route::get('/vehicle-requisition/show', [VehicleRequisitionController::class, 'requisitionShow'])->name('requisition.show');
Route::get('/load_requisition_view/{id}', [VehicleRequisitionController::class, 'load_requisition_view'])->name('load_requisition_view');
Route::get('/vehicle-requisition/forward/{id}', [VehicleRequisitionController::class, 'forwardRequisition'])->name('requisition.forward');
Route::get('/employee-vehicle-requisition/department/head', [VehicleRequisitionController::class, 'employeeRequisitionTOHead'])->name('vehicle.requisition.head.list');
Route::get('/employee-vehicle-requisition/director', [VehicleRequisitionController::class, 'employeeRequisitionTOdirector'])->name('vehicle.requisition.director.list');
Route::get('/employee-vehicle-requisition/dgm', [VehicleRequisitionController::class, 'employeeRequisitionToDGM'])->name('vehicle.requisition.dgm.list');
Route::get('/employee-vehicle-requisition/TSO', [VehicleRequisitionController::class, 'employeeRequisitionTSO'])->name('vehicle.requisition.tso.list');
Route::get('/vehicle-requisition-employee-list', [VehicleRequisitionController::class, 'employeeReequisitionList'])->name('vehicle.requisition.employee.list');
Route::post('/vehicle-requisition/store', [VehicleRequisitionController::class, 'store'])->name('vehicle.requisition.store');
Route::get('/vehicle-requisition/reject/{id}', [VehicleRequisitionController::class, 'rejectRequisition'])->name('requisition.reject');


Route::get('/vehicle-assign/{requisition_id}', [VehicleRequisitionController::class, 'vehicleAssignForm'])->name('vehicle.assign');
Route::post('/vehicle-assign/store/{requisition_id}', [VehicleRequisitionController::class, 'assignVehicle'])->name('requisition.assignVehicle');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/************************************* Site Manager Route List ********************* */

// Route::prefix('money-requisition')->group(function () {
//     Route::get('/entry',[FinancialRequisitionController::class, 'requisitionForm'])->name('money-requisition-entry');
//     Route::post('/store',[FinancialRequisitionController::class, 'storeRequisition'])->name('money-requisition-store');
//     Route::post('/update',[FinancialRequisitionController::class, 'updateRequisition'])->name('money-requisition-update');
//     Route::get('/list', [FinancialRequisitionController::class, 'requisitionList'])->name('money-requisition-list');
//     Route::get('/reject/list', [FinancialRequisitionController::class, 'rejectRequisitionList'])->name('reject-requisition-list');
//     Route::get('/site-print', [FinancialRequisitionController::class, 'print']);
//     Route::get('/site-pdf', [FinancialRequisitionController::class, 'pdf']);
// });



//================ Cache Clear Route ==================//

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');

    return redirect('home');
    // return redirect()->back();
});


