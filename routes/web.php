<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\WifiLogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\InHouseLogsController;
use App\Http\Controllers\InHouseClassificationsController;

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
            return view('form');
        })->name('admin.form');
        Route::get('/violations', [FormController::class, 'showForm'])->name('admin.result');
        Route::get('/quicklog', function () {
            return view('quicklog');
        })->name('admin.quicklog');
        Route::post('/quicklog', [FormController::class, 'receipt']);
        Route::post('/input', [FormController::class, 'store'])->name('admin.store');
        Route::get('/edit/{selectedId}', [FormController::class, 'edit'])->name('edit');
        // for search
        Route::get('/search',[FormController::class, 'search'])->name('admin.search');
        // for filtering
        Route::get('/filter', [FormController::class, 'filter'])->name('filter');
        // for test search something
        Route::post('/patron/search', [FormController::class, 'findPatron']);
        // get card num
        Route::post('/select', [FormController::class, 'select'])->name('admin.select');
/*
|--------------------------------------------------------------------------
| WiFi Logging Management System
|--------------------------------------------------------------------------
*/
        Route::get('/wifi', function () {
            return view('wifi');
        })->name('admin.wifi');
        Route::get('/chart', [WifiLogsController::class, 'chart'])->name('chart');

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
    
/*|--------------------------------------------------------------------------
| Dashboard 
|--------------------------------------------------------------------------
*/   
    
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//(UPDATE ONLY) 
Route::get('/dashboard/{selectedKeyCollections}', [CollectionsController::class, 'getData']);

Route::post('/dashboard/updateCollections', [DashboardController::class, 'updateCollections']);
Route::post('/dashboard/updateFacilities', [DashboardController::class, 'updateFacilities']);
Route::post('/dashboard/updateServices', [DashboardController::class, 'updateServices']);
Route::post('/dashboard/updateLinkages', [DashboardController::class, 'updateLinkages']);
Route::post('/dashboard/updatePersonnel', [DashboardController::class, 'updatePersonnel']);


// Utilization
Route::post('/dashboard/addUtilizationYear', [DashboardController::class, 'newUtilYear']);
Route::post('/dashboard/updateUtilizationYear', [DashboardController::class, 'updateUtilYear']);

// Satisfaction Rating
Route::post('/dashboard/addSatisfactionYear', [DashboardController::class, 'newSatisYear']);
Route::post('/dashboard/updateSatisfactionYear', [DashboardController::class, 'updateSatisYear']);

    
    
    });
});