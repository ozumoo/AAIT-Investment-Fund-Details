<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/company',  [CompanyController::class, 'index'])->name('company-form');
Route::post('/company', [CompanyController::class, 'store']);
Route::get('/historical-quotes', [CompanyController::class, 'showHistoricalQuotes'])->name('historical-quotes');
