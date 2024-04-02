<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', function() {
            return redirect()->route('admin.home');
        });
        Route::get('/home', function () {
            return view('welcome');
        })->name('admin.home');
        Route::get('/test', function () {
            return view('welcome');
        })->name('admin.test');

        // INHOUSE CONTROLLER
        Route::get('/inhouse', [InHouseClassificationsController::class, 'index'])->name('admin.inhouse');
        Route::get('/inhouse/editclassification', [InHouseClassificationsController::class, 'editView'])->name('admin.editclass');
        Route::get('/inhouse/editclassification/{id}', [InHouseClassificationsController::class, 'edit']);
        Route::get('/inhouse/classification/{id}', [InHouseClassificationsController::class, 'show']);
        

        Route::post('/inhouse/addclassification', [InHouseClassificationsController::class, 'store'])->name('admin.InHouseAddClass');
        Route::post('/inhouse/addlogs', [InHouseLogsController::class, 'store'])->name('admin.InHouseAddLogs');
        Route::post('/inhouse/editclassification/{id}/edit', [InHouseClassificationsController::class, 'update']);
        
        


    });
});
// Route::get('/cvsu_ils/sample', function () {
//     return view('file');
// });

// Route::get('/cvsu_ils/sample3', function () {
//     return view('third');
// });