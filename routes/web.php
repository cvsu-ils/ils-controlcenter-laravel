<?php

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\WifiLogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\CollectionsController;
use App\Http\Controllers\InHouseLogsController;
use App\Http\Controllers\LTX\CatalogController;
use App\Http\Controllers\AccessManagementController;
use App\Http\Controllers\LTX\LCClassificationController;
use App\Http\Controllers\InHouseClassificationsController;
use App\Http\Controllers\LTX\DashboardController as LTXDashboardController;

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
Route::get('/', [LandingController::class, 'show'])->name('landing');
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
        Route::post('/store', [ViolationController::class, 'store'])->name('admin.store')->middleware('log.activity');
        Route::get('/update/{id}', [ViolationController::class, 'update'])->name('update')->middleware('log.activity');
        Route::post('/store', [ViolationController::class, 'store'])->name('admin.store');
        Route::get('/update/{id}', [ViolationController::class, 'update'])->name('update');
        Route::get('/search',[ViolationController::class, 'search'])->name('admin.search');
        Route::get('/filter', [ViolationController::class, 'filter'])->name('filter');
        Route::post('/patron/search', [ViolationController::class, 'findPatron']);
        Route::post('/select', [ViolationController::class, 'select'])->name('admin.select');
    /*
    |--------------------------------------------------------------------------
    | WiFi Logging Management System
    |--------------------------------------------------------------------------
    */
        Route::get('/wifi', [WifiLogsController::class, 'index'])->name('admin.wifi');
        Route::get('/chart', [WifiLogsController::class, 'chart'])->name('chart');
        Route::get('/recent', [WifiLogsController::class, 'recent'])->name('recent');
        Route::post('/admin.wifi', [WifiLogsController::class, 'store'])->name('store')->middleware('log.activity');
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
        Route::post('/inhouse/addlogs', [InHouseLogsController::class, 'store'])->name('admin.InHouseAddLogs')->middleware('log.activity');
        Route::patch('/inhouse/editclassification/{id}/edit', [InHouseClassificationsController::class, 'update'])->middleware('log.activity');
        Route::post('/inhouse/addlogs', [InHouseLogsController::class, 'store'])->name('admin.InHouseAddLogs');
        Route::patch('/inhouse/editclassification/{id}/edit', [InHouseClassificationsController::class, 'update']);
    /*
    |--------------------------------------------------------------------------
    | Access Management System
    |--------------------------------------------------------------------------
    */
        Route::get('/access-management', [AccessManagementController::class, 'index'])->name('admin.access-management');
        Route::post('/access-management', [AccessManagementController::class, 'store'])->name('admin.access-management-store');
    
        Route::get('/access-management/user', [AccessManagementController::class, 'user'])->name('admin.access-management-user');
        Route::post('/access-management/user', [AccessManagementController::class, 'storeUser'])->name('admin.access-management-store-user');
        Route::put('/access-management/user/{id}', [AccessManagementController::class, 'editUser'])->name('admin.access-management-edit-user');
        Route::delete('/access-management/user/{id}', [AccessManagementController::class, 'destroyUser'])->name('admin.access-management-destroy-user');

        Route::get('/access-management/permissions', [AccessManagementController::class, 'permission'])->name('admin.access-management-permission');        
        Route::post('/access-management/permissions', [AccessManagementController::class, 'storePermission'])->name('admin.access-management-store-permission');
        Route::put('/access-management/permission/{id}', [AccessManagementController::class, 'editPermission'])->name('admin.access-management-edit-permission');
        Route::delete('/access-management/permission/{id}', [AccessManagementController::class, 'destroyPermission'])->name('admin.access-management-destroy-permission');
        
        Route::get('/access-management/roles', [AccessManagementController::class, 'role'])->name('admin.access-management-role');
        Route::post('/access-management/roles', [AccessManagementController::class, 'storeRole'])->name('admin.access-management-store-role');
        Route::put('/access-management/role/{id}', [AccessManagementController::class, 'editRole'])->name('admin.access-management-edit-role');
        Route::delete('/access-management/role/{id}', [AccessManagementController::class, 'destroyRole'])->name('admin.access-management-destroy-role');
    
      /*--------------------------------------------------------------------------
      | Dashboard 
      |--------------------------------------------------------------------------
      */   

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
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
    /*
    |--------------------------------------------------------------------------
    | Ladislao Theses Xplorer
    |--------------------------------------------------------------------------
    */
        Route::get('/ltx/dashboard', [LTXDashboardController::class, 'index'])->name('admin.ltx.dashboard');
        Route::get('/ltx/catalog', [CatalogController::class, 'index'])->name('admin.ltx.catalog');
        Route::post('/ltx/linkChecker', [CatalogController::class, 'checkUrl'])->name('admin.ltx.linkChecker');
        Route::get('/ltx/create', [LCClassificationController::class, 'index'])->name('admin.ltx.create');
        Route::post('/ltx/subclass', [LCClassificationController::class, 'getSubClass'])->name('admin.ltx.subclasses');
        Route::post('/ltx/ranges', [LCClassificationController::class, 'getRange'])->name('admin.ltx.ranges');
        Route::post('/ltx/store', [CatalogController::class, 'store'])->name('admin.ltx.store');
        Route::get('/ltx/{id}/edit', [CatalogController::class, 'edit'])->name('admin.ltx.edit');
    });
});

   