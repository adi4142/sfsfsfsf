<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\EmployeeController;

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

Route::get('/role', [RoleController::class, 'index'])->name('role.index');
Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
Route::post('/role', [RoleController::class, 'store'])->name('role.store');
Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

Route::get('/division', [DivisionController::class, 'index'])->name('division.index');
Route::get('/division/create', [DivisionController::class, 'create'])->name('division.create');
Route::post('/division', [DivisionController::class, 'store'])->name('division.store');
Route::get('/division/{id}/edit', [DivisionController::class, 'edit'])->name('division.edit');
Route::put('/division/{id}', [DivisionController::class, 'update'])->name('division.update');
Route::delete('/division/{id}', [DivisionController::class, 'destroy'])->name('division.destroy');

Route::get('/departement', [DepartementController::class, 'index'])->name('departement.index');
Route::get('/departement/create', [DepartementController::class, 'create'])->name('departement.create');
Route::post('/departement', [DepartementController::class, 'store'])->name('departement.store');
Route::get('/departement/{id}/edit', [DepartementController::class, 'edit'])->name('departement.edit');
Route::put('/departement/{id}', [DepartementController::class, 'update'])->name('departement.update');
Route::delete('/departement/{id}', [DepartementController::class, 'destroy'])->name('departement.destroy');

Route::get('/position', [PositionController::class, 'index'])->name('position.index');
Route::get('/position/create', [PositionController::class, 'create'])->name('position.create');
Route::post('/position', [PositionController::class, 'store'])->name('position.store');
Route::get('/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
Route::put('/position/{id}', [PositionController::class, 'update'])->name('position.update');
Route::delete('/position/{id}', [PositionController::class, 'destroy'])->name('position.destroy');

Route::get('/user', [UsersController::class, 'index'])->name('user.index');
Route::get('/user/create', [UsersController::class, 'create'])->name('user.create');
Route::post('/user', [UsersController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UsersController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [UsersController::class, 'destroy'])->name('user.destroy');

Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
Route::get('/payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
Route::get('/payroll/{id}/edit', [PayrollController::class, 'edit'])->name('payroll.edit');
Route::put('/payroll/{id}', [PayrollController::class, 'update'])->name('payroll.update');
Route::delete('/payroll/{id}', [PayrollController::class, 'destroy'])->name('payroll.destroy');

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');