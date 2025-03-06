<?php


use App\Http\Controllers\Api\OperatorWorkOrderController;
use App\Http\Controllers\Api\ProgressManagementController;
use App\Http\Controllers\Api\ReportManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Operator Work Order APIs
Route::get('/workorders', [OperatorWorkOrderController::class, 'index']);
Route::get('/workorders/{id}', [OperatorWorkOrderController::class, 'show']);
Route::put('/workorders/{id}', [OperatorWorkOrderController::class, 'update']);

Route::get('/report/rekap', [ReportManagementController::class, 'reportRekapWorkOrder']);
Route::get('/report/operator', [ReportManagementController::class, 'reportOperatorResult']);
Route::get('/progress/{workOrderId}', [ProgressManagementController::class, 'showProgress']);
