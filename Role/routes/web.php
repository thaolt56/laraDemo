<?php

use App\Exports\UsersExport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersExportController;
use App\Http\Controllers\PermissionController;
use App\Models\Permisson;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/admin/role', [RoleController::class, 'index']);
Route::get('/admin/addRole', [RoleController::class, 'add']);
//permission 
Route::get('/admin/permission', [PermissionController::class, 'index'])->name('permission.index');
Route::post('/admin/permission/store', [PermissionController::class, 'store'])->name('permission.store');
Route::get('/admin/permission/delete/{id}', [PermissionController::class, 'delete'])->name('permission.delete');
Route::get('/admin/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
Route::post('/admin/permission/update/{id}', [PermissionController::class, 'update'])->name('permission.update');


//list roles
Route::get('/admin/role', [RoleController::class, 'index'])->name('role.index');


//add roles
Route::get('/admin/role/add', [RoleController::class, 'add'])->name('role.add');
Route::post('/admin/role/store', [RoleController::class, 'store'])->name('role.store');
Route::get('/admin/role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/admin/role/update/{role}', [RoleController::class, 'update'])->name('role.update');
Route::get('/admin/role/delete/{role}', [RoleController::class, 'delete'])->name('role.delete');

//users
Route::get('/admin/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/admin/user/update/{user}', [UserController::class, 'update'])->name('user.update');

Route::get('/admin/user/list', [UserController::class, 'list'])->name('user.list');
Route::get('/admin/user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');


//export excel csv
Route::get('/admin/users/export', [UsersExportController::class, 'export'])->name('user.export ');

//import excel users
Route::get('/admin/users/import', [UserController::class, 'importUsers'])->name('user.import');
Route::post('/admin/users/import/store', [UserController::class, 'importStore'])->name('import.store');
