<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WifiLogsController;

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
        Route::get('/wifi', function () {
            return view('wifi');
        })->name('admin.wifi');
        Route::post('/admin.wifi', [App\Http\Controllers\WifiLogsController::class, 'store'])->name('store');
        
        
    });
});
// Route::get('/cvsu_ils/sample', function () {
//     return view('file');
// });

// Route::get('/cvsu_ils/sample3', function () {
//     return view('third');
// });