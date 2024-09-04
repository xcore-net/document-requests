<?php

use App\Http\Controllers\api\ApiAuthController;
use App\Http\Controllers\api\ApiBillController;
use App\Http\Controllers\api\ApiClientController;
use App\Http\Controllers\api\ApiDepartmentController;
use App\Http\Controllers\api\ApiEmployeeController;
use App\Http\Controllers\api\ApiFormController;
use App\Http\Controllers\Api\ApiRequestController;
use App\Http\Controllers\api\ApiRequestTypeController;
use App\Http\Controllers\api\ApiStageTypeController;
use App\Http\Controllers\api\ApiTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(
    function () {
        //Form
        Route::middleware('Role:user')->group(function () {
            Route::get('forms', [ApiFormController::class, 'getAllForms']);
            Route::get('form/{id}', [ApiFormController::class, 'getForm']);
        });
        Route::middleware('Role:admin')->group(function () {
            Route::post('form', [ApiFormController::class, 'createForm']);
            Route::put('form/{id}', [ApiFormController::class, 'updateForm']);
            Route::delete('form/{id}', [ApiFormController::class, 'deleteForm']);
        });

        //Bill
        Route::middleware('Role:user')->group(function () {
            Route::get('bills', [ApiBillController::class, 'getAllBills']);
            Route::get('bill/{id}', [ApiBillController::class, 'getBill']);
        });
        Route::middleware('Role:admin')->group(function () {
            Route::post('bill', [ApiBillController::class, 'createBill']);
            Route::put('bill/{id}', [ApiBillController::class, 'updateBill']);
            Route::delete('bill/{id}', [ApiBillController::class, 'deleteBill']);
        });

        //Request type
        Route::middleware('Role:user')->group(function () {
            Route::get('request-types', [ApiRequestTypeController::class, 'getAllRequestTypes']);
            Route::get('request-type/{id}', [ApiRequestTypeController::class, 'getRequestType']);
        });
        Route::middleware('Role:admin')->group(function () {
            Route::post('request-type', [ApiRequestTypeController::class, 'createRequestType']);
            Route::put('request-type/{id}', [ApiRequestTypeController::class, 'updateRequestType']);
            Route::delete('request-type/{id}', [ApiRequestTypeController::class, 'deleteRequestType']);

            Route::post('request-type/{id}/add-stages', [ApiRequestTypeController::class, 'addStages']);
            Route::post('request-type/{id}/add-stage', [ApiRequestTypeController::class, 'addStage']);
            Route::post('request-type/{id}/remove-all-stages', [ApiRequestTypeController::class, 'removeAllStages']);
            Route::post('request-type/{id}/remove-stage', [ApiRequestTypeController::class, 'removeStage']);
        });

        //Stage type
        Route::middleware('Role:admin')->group(function () {
            Route::get('stage-types', [ApiStageTypeController::class, 'getAllStageTypes']);
            Route::get('stage-types/{id}', [ApiStageTypeController::class, 'getStageType']);
            Route::post('stage-type', [ApiStageTypeController::class, 'createStageType']);
            Route::put('stage-type/{id}', [ApiStageTypeController::class, 'updateStageType']);
            Route::delete('stage-type/{id}', [ApiStageTypeController::class, 'deleteStageType']);
        });

        //Request
        Route::middleware('Role:user')->group(function () {
            Route::get('user/requests', [ApiRequestController::class, 'getUserRequests']);
            Route::get('user/request/{id}', [ApiRequestController::class, 'getUserRequest']);
            Route::post('user/request', [ApiRequestController::class, 'createUserRequest']);
            Route::put('user/request/{id}', [ApiRequestController::class, 'updateUserRequest']);
            Route::post('user/request/{id}/pay', [ApiRequestController::class, 'pay']);
            Route::post('user/request/{id}/fill', [ApiRequestController::class, 'fill']);
            Route::post('user/request/{id}/advance', [ApiRequestController::class, 'advance']);
        });
        Route::middleware('Role:employee')->group(function () {
            Route::get('requests', [ApiRequestController::class, 'getRequests']);
            Route::get('requests/active', [ApiRequestController::class, 'getActiveRequests']);
            Route::get('requests/archived', [ApiRequestController::class, 'getArchivedRequests']);
            Route::get('request/{id}', [ApiRequestController::class, 'getRequest']);

            Route::get('request/{id}/form', [ApiRequestController::class, 'getRequestForm']);
            Route::get('request/{id}/bill', [ApiRequestController::class, 'getRequestBill']);
            Route::get('request/{id}/filled-form', [ApiRequestController::class, 'getRequestFilledForm']);
            Route::get('request/{id}/payment', [ApiRequestController::class, 'getRequestPayment']);
        });

        //Task
        Route::middleware('Role:user')->group(function () {
            Route::get('user/tasks', [ApiTaskController::class, 'getUserTasks']);
            Route::get('user/task/{id}', [ApiTaskController::class, 'getUserTask']);
        });
        Route::middleware('Role:employee')->group(function () {
            Route::get('tasks', [ApiTaskController::class, 'getTasks']);
            Route::get('tasks/active', [ApiTaskController::class, 'getActiveTasks']);
            Route::get('tasks/archived', [ApiTaskController::class, 'getArchivedTasks']);
            Route::get('task/{id}', [ApiTaskController::class, 'getTask']);
            Route::get('task/{task_id}/receive ', [ApiTaskController::class, 'receiveTask']);
            Route::get('task/{task_id}/assign/{user_id}', [ApiTaskController::class, 'assignTask']);
            Route::get('task/{id}/control/{action}', [ApiTaskController::class, 'controlTask']);
        });

        //Department
        Route::middleware('Role:admin||employee')->group(function () {
            Route::get('departments', [ApiDepartmentController::class, 'getAllDepartments']);
            Route::get('department/{id}', [ApiDepartmentController::class, 'getDepartment']);
        });
        Route::middleware('Role:admin')->group(function () {
            Route::post('department', [ApiDepartmentController::class, 'createDepartment']);
            Route::put('department/{id}', [ApiDepartmentController::class, 'updateDepartment']);
            Route::delete('department/{id}', [ApiDepartmentController::class, 'deleteDepartment']);
        });

        //Employee
        Route::middleware('Role:admin||supervisor')->group(function () {
            Route::get('employees', [ApiEmployeeController::class, 'getAllEmployees']);
            Route::get('employee/{id}', [ApiEmployeeController::class, 'getEmployee']);
            Route::post('employee', [ApiEmployeeController::class, 'createEmployee']);
            Route::put('employee/{id}', [ApiEmployeeController::class, 'updateEmployee']);
            Route::delete('employee/{id}', [ApiEmployeeController::class, 'deleteEmployee']);
        });

        //Client
        Route::middleware('Role:admin||employee')->group(function () {
            Route::get('clients', [ApiClientController::class, 'getAllClients']);
            Route::get('client/{id}', [ApiClientController::class, 'getClient']);
            Route::post('client', [ApiClientController::class, 'createClient']);
            Route::put('client/{id}', [ApiClientController::class, 'updateClient']);
            Route::delete('client/{id}', [ApiClientController::class, 'deleteClient']);
        });
    }
);
