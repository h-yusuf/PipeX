<?php

use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\Tables\DummyController;
use App\Http\Controllers\api\apiGateway;
use App\Http\Controllers\api\AutomasiSystem;
use App\Http\Controllers\api\getAllApisController;
use App\Http\Controllers\api\HugingFaceAicheduleAdvisorController;
use App\Http\Controllers\api\OpenAIScheduleAdvisorController;
use App\Http\Controllers\FailureController;
use App\Services\StationService;
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


   