<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/employee');
Route::resource('/employee', App\Http\Controllers\EmployeeController::class);

Route::get('/lang/set/{code}', [App\Http\Controllers\LanguageController::class, 'setLanguage'])->name('lang.set');