<?php

use App\Http\Api\Controllers\ApiRequestController;
use App\Http\Controllers\Api\ApiBillController;
use App\Http\Controllers\Api\ApiFormController;
use App\Http\Controllers\Api\ApiRequestTypeController;
use App\Http\Controllers\Api\ApiStageController;
use App\Http\Controllers\Api\ApiStageTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserAuthController;

Route::post('register',[UserAuthController::class,'register']);
Route::post('login',[UserAuthController::class,'login']);
Route::post('logout',[UserAuthController::class,'logout']) ->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(
    function () {
//         //Form
Route::get('Form/index', [ApiFormController::class, 'index']);
Route::post('Form/store', [ApiFormController::class, 'store']);
Route::post('Form/update/{id}', [ApiFormController::class, 'update']);
Route::delete('Form/delete/{id}', [ApiFormController::class, 'destroy']);
Route::get('Form/show/{id}', [ApiFormController::class, 'show']);

//         //Bill
         Route::get('Bill/index', [ApiBillController::class, 'index']);
        Route::post('Bill/store', [ApiBillController::class, 'store']);
        Route::post('Bill/update/{id}', [ApiBillController::class, 'update']);
        Route::delete('Bill/delete/{id}', [ApiBillController::class, 'destroy']);
        Route::get('Bill/show/{id}', [ApiBillController::class, 'show']);


//         //Request type
        Route::get('requestType/index', [ApiRequestTypeController::class, 'index']);
        Route::post('requestType/store', [ApiRequestTypeController::class, 'store']);
        Route::post('requestType/update/{id}', [ApiRequestTypeController::class, 'update']);
        Route::delete('requestType/delete/{id}', [ApiRequestTypeController::class, 'destroy']);

//         //Request
//         Route::get('user/requests', [ApiRequestController::class, 'getUserRequests']);
//         Route::get('user/request/{id}', [ApiRequestController::class, 'getUserRequest']);
//         Route::post('user/request', [ApiRequestController::class, 'createUserRequest']);
//         Route::put('user/request/{id}', [ApiRequestController::class, 'updateUserRequest']);

//         Route::get('work/requests', [ApiRequestController::class, 'getRequests']);
//         Route::get('work/requests/active', [ApiRequestController::class, 'getActiveRequests']);
//         Route::get('work/requests/archived', [ApiRequestController::class, 'getActiveRequests']);
//         Route::get('work/requests/{id}', [ApiRequestController::class, 'getRequest']);
  
//Request 
Route::get('Request/index', [ApiRequestController::class, 'index']);
Route::post('Request/store', [ApiRequestController::class, 'store']);
Route::post('Request/update/{id}', [ApiRequestController::class, 'update']);
Route::delete('Request/delete/{id}', [ApiRequestController::class, 'destroy']);
Route::get('Request/show/{id}', [ApiRequestController::class, 'show']);
//Stage
Route::get('Stage/index', [ApiStageController::class, 'index']);
Route::post('Stage/store', [ApiStageController::class, 'store']);
Route::post('Stage/update/{id}', [ApiStageController::class, 'update']);
Route::delete('Stage/delete/{id}', [ApiStageController::class, 'destroy']);
Route::get('Stage/show/{id}', [ApiStageController::class, 'show']);

//stagetype

Route::get('StageType/index', [ApiStageTypeController::class, 'index']);
Route::post('StageType/store', [ApiStageTypeController::class, 'store']);
Route::post('StageType/update/{id}', [ApiStageTypeController::class, 'update']);
Route::delete('StageType/delete/{id}', [ApiStageTypeController::class, 'destroy']);
Route::get('StageType/show/{id}', [ApiStageTypeController::class, 'show']);


  }
);