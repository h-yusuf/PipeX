<?php


use App\Http\Controllers\Admin\ManagementProductController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Api\OperatorWorkOrderController;
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

    // Route::resource('/products', 'ManagementProductController');

    // product start
    Route::get('/product', [ManagementProductController::class, 'index'])->name('product.index');
    Route::post('/product/store', [ManagementProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ManagementProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ManagementProductController::class, 'update'])->name('product.update');
    Route::delete('/product/destroy/{id}', [ManagementProductController::class, 'destroy'])->name('product.destroy');
    // product end

    // workorder start
    Route::get('/workorder', [WorkOrderController::class, 'index'])->name('workorder');
    Route::post('/workorder/store', [WorkOrderController::class, 'store'])->name('workorder.store');
    Route::get('/workorder/{id}/edit', [WorkOrderController::class, 'edit'])->name('workorder.edit');
    Route::put('/workorder/{id}/update', [WorkOrderController::class, 'update'])->name('workorder.update');
    Route::delete('/workorder/destroy/{id}', [WorkOrderController::class, 'destroy'])->name('workorder.destroy');
    // workorder end

    // reportManagement start
    Route::get('/reportManagement', [WorkOrderController::class, 'reportManagement'])->name('reportManagement');
    // reportManagement end

});

// operator start
Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'OperatorAccess']], function () {
    Route::get('/operator', [WorkOrderController::class, 'operatorIndex'])->name('operator');
    Route::get('/api-workorders', [OperatorWorkOrderController::class, 'index']);
    Route::get('/api-workorder/{id}', [OperatorWorkOrderController::class, 'show']);
    Route::put('/api-workorder/{id}/update', [OperatorWorkOrderController::class, 'update']);
    Route::put('/api-workorder/{id}/update-qty', [OperatorWorkOrderController::class, 'updateQty']);

});
// operator end


Route::view('/offline', 'offline');

