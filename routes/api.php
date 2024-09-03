<?php

use App\Http\Controllers\api\ApiAuthController;
use App\Http\Controllers\api\ApiBillController;
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
        Route::get('forms', [ApiFormController::class, 'getAllForms']);
        Route::get('form/{id}', [ApiFormController::class, 'getForm']);
        Route::post('form', [ApiFormController::class, 'createForm']);
        Route::put('form/{id}', [ApiFormController::class, 'updateForm']);
        Route::delete('form/{id}', [ApiFormController::class, 'deleteForm']);

        //Bill
        Route::get('bills', [ApiBillController::class, 'getAllBills']);
        Route::get('bill/{id}', [ApiBillController::class, 'getBill']);
        Route::post('bill', [ApiBillController::class, 'createBill']);
        Route::put('bill/{id}', [ApiBillController::class, 'updateBill']);
        Route::delete('bill/{id}', [ApiBillController::class, 'deleteBill']);
        
        //Request type
        Route::get('request-types', [ApiRequestTypeController::class, 'getAllRequestTypes']);
        Route::get('request-type/{id}', [ApiRequestTypeController::class, 'getRequestType']);
        Route::post('request-type', [ApiRequestTypeController::class, 'createRequestType']);
        Route::put('request-type/{id}', [ApiRequestTypeController::class, 'updateRequestType']);
        Route::delete('request-type/{id}', [ApiRequestTypeController::class, 'deleteRequestType']);
        
        Route::post('request-type/{id}/add-stages', [ApiRequestTypeController::class, 'addStages']);
        Route::post('request-type/{id}/add-stage', [ApiRequestTypeController::class, 'addStage']);
        Route::post('request-type/{id}/remove-all-stages', [ApiRequestTypeController::class, 'removeAllStages']);
        Route::post('request-type/{id}/remove-stage', [ApiRequestTypeController::class, 'removeStage']);

        //Stage type
        Route::get('stage-types', [ApiStageTypeController::class, 'getAllStageTypes']);
        Route::get('stage-types/{id}', [ApiStageTypeController::class, 'getStageType']);
        Route::post('stage-type', [ApiStageTypeController::class, 'createStageType']);
        Route::put('stage-type/{id}', [ApiStageTypeController::class, 'updateStageType']);
        Route::delete('stage-type/{id}', [ApiStageTypeController::class, 'deleteStageType']);

        //Request
        Route::get('user/requests', [ApiRequestController::class, 'getUserRequests']);
        Route::get('user/request/{id}', [ApiRequestController::class, 'getUserRequest']);
        Route::post('user/request', [ApiRequestController::class, 'createUserRequest']);
        Route::put('user/request/{id}', [ApiRequestController::class, 'updateUserRequest']);
        Route::post('user/request/{id}/pay', [ApiRequestController::class, 'pay']);
        Route::post('user/request/{id}/fill', [ApiRequestController::class, 'fill']);

        Route::get('work/requests', [ApiRequestController::class, 'getRequests']);
        Route::get('work/requests/active', [ApiRequestController::class, 'getActiveRequests']);
        Route::get('work/requests/archived', [ApiRequestController::class, 'getArchivedRequests']);
        Route::get('work/request/{id}', [ApiRequestController::class, 'getRequest']);
        
        Route::get('work/request/{id}/form', [ApiRequestController::class, 'getRequestForm']);
        Route::get('work/request/{id}/bill', [ApiRequestController::class, 'getRequestBill']);
        Route::get('work/request/{id}/filled-form', [ApiRequestController::class, 'getRequestFilledForm']);
        Route::get('work/request/{id}/payment', [ApiRequestController::class, 'getRequestPayment']);

        //Task
        Route::get('work/tasks', [ApiTaskController::class, 'getTasks']);
        Route::get('work/tasks/active', [ApiTaskController::class, 'getActiveTasks']);
        Route::get('work/tasks/archived', [ApiTaskController::class, 'getArchivedTasks']);
        Route::get('work/task/{id}', [ApiTaskController::class, 'getTask']);

        Route::get('work/task/{task_id}/recieve', [ApiTaskController::class, 'assignTask']);
        Route::get('work/task/{task_id}/assign/{user_id}', [ApiTaskController::class, 'assignTask']);
        Route::get('work/task/{id}/control/{action}', [ApiTaskController::class, 'controlTask']);
    }
);
