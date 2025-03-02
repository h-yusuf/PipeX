<?php


use App\Http\Controllers\Admin\ManagementProductController;
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
   
    Route::resource('/products', 'ManagementProductController');

    Route::get('/product', [ManagementProductController::class, 'index'])->name('product');
    Route::post('/product/store', [ManagementProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/edit', [ManagementProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ManagementProductController::class, 'update'])->name('product.update');
    Route::delete('/product/destroy/{id}', [ManagementProductController::class, 'destroy'])->name('product.destroy');


});

Route::view('/offline', 'offline');

