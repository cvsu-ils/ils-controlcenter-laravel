<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\WifiLogsController;
use App\Http\Controllers\InHouseClassificationsController;
use App\Http\Controllers\InHouseLogsController;

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
    return view('landing');
})->name('landing');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', function() {
            return redirect()->route('admin.home');
        });
        Route::get('/home', function () {
            return view('welcome');
        })->name('admin.home');
      
    /*
    |--------------------------------------------------------------------------
    | Violation Management System
    |--------------------------------------------------------------------------
    */
        Route::get('/violations/create', function () {
            return view('violationForm');
        })->name('admin.violationList');

        Route::get('/violations', [ViolationController::class, 'showForm'])->name('admin.result');
        Route::post('/store', [ViolationController::class, 'store'])->name('admin.store');
        Route::get('/edit/{selectedId}', [ViolationController::class, 'edit'])->name('edit');
        Route::get('/search',[ViolationController::class, 'search'])->name('admin.search');
        Route::get('/filter', [ViolationController::class, 'filter'])->name('filter');
        Route::post('/patron/search', [ViolationController::class, 'findPatron']);
        Route::post('/select', [ViolationController::class, 'select'])->name('admin.select');
    /*
    |--------------------------------------------------------------------------
    | WiFi Logging Management System
    |--------------------------------------------------------------------------
    */
        Route::get('/wifi', function () {
            return view('wifi');
        })->name('admin.wifi');
        Route::get('/chart', [WifiLogsController::class, 'chart'])->name('chart');
        Route::get('/recent', [WifiLogsController::class, 'recent'])->name('recent');
        Route::post('/admin.wifi', [WifiLogsController::class, 'store'])->name('store');
    /*
    |--------------------------------------------------------------------------
    | In House Management System
    |--------------------------------------------------------------------------
    */
        Route::get('/inhouse', [InHouseLogsController::class, 'index'])->name('admin.inhouse');
        Route::get('/inhouse/chart', [InHouseLogsController::class, 'chartInfo']);
        Route::get('/inhouse/classification', [InHouseClassificationsController::class, 'class'])->name('admin.inhouse.class');
        Route::get('/inhouse/editclassification', [InHouseClassificationsController::class, 'editView'])->name('admin.editclass');
        Route::get('/inhouse/editclassification/{id}', [InHouseClassificationsController::class, 'edit']);
        Route::get('/inhouse/classification/{id}', [InHouseClassificationsController::class, 'show']);
        Route::post('/inhouse/addclassification', [InHouseClassificationsController::class, 'store'])->name('admin.InHouseAddClass');
        Route::post('/inhouse/addlogs', [InHouseLogsController::class, 'store'])->name('admin.InHouseAddLogs');
        Route::patch('/inhouse/editclassification/{id}/edit', [InHouseClassificationsController::class, 'update']);
    });
});