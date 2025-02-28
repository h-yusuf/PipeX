<?php

use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\ChecksheetController;
use App\Http\Controllers\Admin\DowntimeController;
use App\Http\Controllers\Admin\DurationController;
use App\Http\Controllers\Admin\HistoriesController;
use App\Http\Controllers\Admin\MasterDataProblemController;
use App\Http\Controllers\Admin\PhoneNumberController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\Tables\EngineMasterController;
use App\Http\Controllers\Admin\Tables\SparepartController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\api\apiGateway;
use App\Http\Controllers\api\HugingFaceAicheduleAdvisorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes();



Route::group(['prefix' => "admin", 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'AdminPanelAccess']], function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/users', 'UserController');
    Route::resource('/roles', 'RoleController');
    Route::resource('/permissions', 'PermissionController')->except(['show']);



});

Route::view('/offline', 'offline');

